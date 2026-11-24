<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SubscriptionTier;
use App\Models\SubscriptionSubTier;
use App\Models\SubscriptionSubTierPending;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Helpers\LogActivity;

class SubscriptionSubTierController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:subscription-tier-list|subscription-tier-create|subscription-tier-edit|subscription-tier-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:subscription-tier-create', ['only' => ['store']]);
        $this->middleware('permission:subscription-tier-edit', ['only' => ['update']]);
        $this->middleware('permission:subscription-tier-delete', ['only' => ['destroy']]);
        $this->middleware('permission:subscription-tier-approve|subscription-tier-reject', ['only' => ['subTierStatus']]);
    }

    public function index(Request $request)
    {
        if (!Auth::user()->can('subscription-tier-list') && !Auth::user()->hasPermissionTo('subscription-tier-list')) {
            abort(403, 'Unauthorized action.');
        }

        $tiers = SubscriptionTier::where('status', 1)->orderBy('created_at', 'desc')->get();

        $user = Auth::user();
        $permission = 'subscription-tier-approve';

        $authoriser = User::where('group_id', $user->group_id)->where('status', 1)
            ->permission($permission)
            ->get();

        $canViewAll = $user->hasPermissionTo('view-all-subscriptions');

        $query = SubscriptionSubTier::where(function ($query) use ($user, $canViewAll) {
            $query->where('group_id', $user->group_id);

            if ($canViewAll) {
                $query->orWhereNotNull('id');
            }
        });

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $data = $query->with('tier')->orderBy('created_at', 'desc')->paginate(10);

        return view('subscriptiontiers.subtiers', compact('data', 'tiers', 'authoriser'));
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $user = User::find($user_id);

        if ($request->filled('promo_start_at')) {
            try {
                $raw = str_replace('/', '-', $request->promo_start_at);
                $request->merge(['promo_start_at' => \Carbon\Carbon::parse($raw)->format('Y-m-d H:i:s')]);
            } catch (\Exception $e) {}
        }
        if ($request->filled('promo_end_at')) {
            try {
                $raw = str_replace('/', '-', $request->promo_end_at);
                $request->merge(['promo_end_at' => \Carbon\Carbon::parse($raw)->format('Y-m-d H:i:s')]);
            } catch (\Exception $e) {}
        }

        $this->validate($request, [
            'name' => 'required',
            'subscription_tier_id' => 'required|exists:subscription_tiers,id',
            'description' => 'nullable|string',
            'is_promotional' => 'nullable',
            'promo_tab_title' => 'nullable|string|max:191',
            'promo_badge' => 'nullable|string|max:100',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'promo_features' => 'nullable|string',
            'promo_start_at' => 'nullable|date',
            'promo_end_at' => 'nullable|date|after_or_equal:promo_start_at',
        ]);

        $exists = SubscriptionSubTier::where('name', $request->name)
            ->where('subscription_tier_id', $request->subscription_tier_id)
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['name' => 'The sub-tier name already exists under this tier.']);
        }

        $slug = Str::slug($request->name);
        $isPromotional = $request->boolean('is_promotional');
        $promoTabTitle = $request->filled('promo_tab_title') ? $request->promo_tab_title : null;
        $promoBadge = $request->filled('promo_badge') ? $request->promo_badge : null;
        $discountPercentage = $request->filled('discount_percentage') ? (float) $request->discount_percentage : 0;
        $promoFeatures = $request->filled('promo_features') ? $request->promo_features : null;
        $promoStartAt = $request->filled('promo_start_at') ? $request->promo_start_at : null;
        $promoEndAt = $request->filled('promo_end_at') ? $request->promo_end_at : null;

        $subTier = new SubscriptionSubTier();
        $subTier->name = $request->name;
        $subTier->subscription_tier_id = $request->subscription_tier_id;
        $subTier->group_id = $user->group_id;
        $subTier->slug = $slug;
        $subTier->description = $request->description;
        $subTier->is_promotional = $isPromotional;
        $subTier->promo_tab_title = $promoTabTitle;
        $subTier->promo_badge = $promoBadge;
        $subTier->discount_percentage = $discountPercentage;
        $subTier->promo_features = $promoFeatures;
        $subTier->promo_start_at = $promoStartAt;
        $subTier->promo_end_at = $promoEndAt;
        $subTier->save();

        $subTier_pending = new SubscriptionSubTierPending();
        $subTier_pending->name = $request->name;
        $subTier_pending->slug = $slug;
        $subTier_pending->subscription_tier_id = $request->subscription_tier_id;
        $subTier_pending->subscription_sub_tier_id = $subTier->id;
        $subTier_pending->group_id = $user->group_id;
        $subTier_pending->description = $request->description;
        $subTier_pending->is_promotional = $isPromotional;
        $subTier_pending->promo_tab_title = $promoTabTitle;
        $subTier_pending->promo_badge = $promoBadge;
        $subTier_pending->discount_percentage = $discountPercentage;
        $subTier_pending->promo_features = $promoFeatures;
        $subTier_pending->promo_start_at = $promoStartAt;
        $subTier_pending->promo_end_at = $promoEndAt;
        $subTier_pending->inputer_id = Auth::user()->id;
        $subTier_pending->status = 0;
        $subTier_pending->action_type = 'Insert';
        $subTier_pending->save();

        $action = $request->name;
        $title = 'Please be advised that a new Subscription Sub-Tier (' . $action . ') has been created and is awaiting your review and approval.';
        LogActivity::addToLog(' Subscription Sub-Tier (' . $request->name . ') created by ' . Auth::user()->name);

        $authorise_email = null;
        if ($request->filled('authorizer_id')) {
            $authorise_user = User::where('id', $request->authorizer_id)->first();
            $authorise_email = $authorise_user ? $authorise_user->email : null;
        }

        if ($authorise_email) {
            $this->insertNotifyUsers($action, $title, $authorise_email);
        }

        $inputter_email = Auth::user()->email;
        $inputter_title = 'Please be advised that a new Subscription Sub-Tier (' . $action . ') has been created.';
        $this->insertNotifyInputter($action, $inputter_title, $inputter_email);

        return redirect()->back()->with('success', 'Subscription sub-tier successfully created and pending approval.');
    }

    public function update(Request $request, $id)
    {
        if ($request->filled('promo_start_at')) {
            try {
                $raw = str_replace('/', '-', $request->promo_start_at);
                $request->merge(['promo_start_at' => \Carbon\Carbon::parse($raw)->format('Y-m-d H:i:s')]);
            } catch (\Exception $e) {}
        }
        if ($request->filled('promo_end_at')) {
            try {
                $raw = str_replace('/', '-', $request->promo_end_at);
                $request->merge(['promo_end_at' => \Carbon\Carbon::parse($raw)->format('Y-m-d H:i:s')]);
            } catch (\Exception $e) {}
        }

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'subscription_tier_id' => 'required|exists:subscription_tiers,id',
            'description' => 'nullable|string',
            'is_promotional' => 'nullable',
            'promo_tab_title' => 'nullable|string|max:191',
            'promo_badge' => 'nullable|string|max:100',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'promo_features' => 'nullable|string',
            'promo_start_at' => 'nullable|date',
            'promo_end_at' => 'nullable|date|after_or_equal:promo_start_at',
        ]);

        $subTier = SubscriptionSubTier::find($id);
        if (!$subTier) {
            return redirect()->back()->with('error', 'Subscription sub-tier not found.');
        }

        $existing = SubscriptionSubTier::where('name', $request->name)
            ->where('subscription_tier_id', $request->subscription_tier_id)
            ->where('id', '!=', $id)
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'A sub-tier with the given name already exists under this tier.');
        }

        $subTier->admin_status = 0;
        $subTier->save();

        $slug = Str::slug($request->name);
        $isPromotional = $request->boolean('is_promotional');
        $promoTabTitle = $request->filled('promo_tab_title') ? $request->promo_tab_title : null;
        $promoBadge = $request->filled('promo_badge') ? $request->promo_badge : null;
        $discountPercentage = $request->filled('discount_percentage') ? (float) $request->discount_percentage : 0;
        $promoFeatures = $request->filled('promo_features') ? $request->promo_features : null;
        $promoStartAt = $request->filled('promo_start_at') ? $request->promo_start_at : null;
        $promoEndAt = $request->filled('promo_end_at') ? $request->promo_end_at : null;

        $subTier_pending = new SubscriptionSubTierPending();
        $subTier_pending->subscription_sub_tier_id = $id;
        $subTier_pending->name = $request->name;
        $subTier_pending->slug = $slug;
        $subTier_pending->subscription_tier_id = $request->subscription_tier_id;
        $subTier_pending->description = $request->description;
        $subTier_pending->is_promotional = $isPromotional;
        $subTier_pending->promo_tab_title = $promoTabTitle;
        $subTier_pending->promo_badge = $promoBadge;
        $subTier_pending->discount_percentage = $discountPercentage;
        $subTier_pending->promo_features = $promoFeatures;
        $subTier_pending->promo_start_at = $promoStartAt;
        $subTier_pending->promo_end_at = $promoEndAt;
        $subTier_pending->inputer_id = Auth::user()->id;
        $subTier_pending->status = 0;
        $subTier_pending->action_type = 'Edit';
        $subTier_pending->save();

        $action = $request->name;
        $title = 'Please be informed the Subscription Sub-Tier (' . $action . ') has been updated and is awaiting your review and approval.';
        LogActivity::addToLog(' Subscription Sub-Tier (' . $request->name . ') update request by ' . Auth::user()->name);

        $authorise_email = null;
        if ($request->filled('authorizer_id')) {
            $authorise_user = User::where('id', $request->authorizer_id)->first();
            $authorise_email = $authorise_user ? $authorise_user->email : null;
        }

        if ($authorise_email) {
            $this->insertNotifyUsers($action, $title, $authorise_email);
        }

        $inputter_email = Auth::user()->email;
        $inputter_title = 'Please be advised that Subscription Sub-Tier (' . $action . ') has been updated.';
        $this->insertNotifyInputter($action, $inputter_title, $inputter_email);

        return redirect()->back()->with('success', 'Subscription sub-tier updated successfully and pending approval.');
    }

    public function destroy(Request $request, $id)
    {
        $subTier = SubscriptionSubTier::find($id);
        if (!$subTier) {
            return redirect()->back()->with('error', 'Subscription sub-tier not found.');
        }

        $subTier->admin_status = 3;
        $subTier->save();

        $subTier_pending = new SubscriptionSubTierPending();
        $subTier_pending->subscription_sub_tier_id = $id;
        $subTier_pending->subscription_tier_id = $subTier->subscription_tier_id;
        $subTier_pending->inputer_id = Auth::user()->id;
        $subTier_pending->status = 0;
        $subTier_pending->action_type = 'Delete';
        $subTier_pending->save();

        $action = $subTier->name;
        $title = 'Please be advised that the Subscription Sub-Tier (' . $action . ') has been deleted and is awaiting your review and approval.';
        LogActivity::addToLog(' Subscription Sub-Tier (' . $action . ') delete request by ' . Auth::user()->name);

        $authorise_email = null;
        if ($request->filled('authorizer_id')) {
            $authorise_user = User::where('id', $request->authorizer_id)->first();
            $authorise_email = $authorise_user ? $authorise_user->email : null;
        }

        if ($authorise_email) {
            $this->insertNotifyUsers($action, $title, $authorise_email);
        }

        $inputter_email = Auth::user()->email;
        $inputter_title = 'Please be advised that Subscription Sub-Tier (' . $action . ') has been deleted.';
        $this->insertNotifyInputter($action, $inputter_title, $inputter_email);

        return redirect()->back()->with('success', 'Subscription sub-tier deleted successfully and pending approval.');
    }

    public function duplicate(Request $request, $id)
    {
        $subTier = SubscriptionSubTier::find($id);
        if (!$subTier) {
            return redirect()->back()->with('error', 'Subscription sub-tier not found.');
        }

        $user = Auth::user();
        $name = $subTier->name . ' (Copy)';
        $slug = Str::slug($name) . '-' . time();

        $copy = new SubscriptionSubTier();
        $copy->name = $name;
        $copy->slug = $slug;
        $copy->subscription_tier_id = $subTier->subscription_tier_id;
        $copy->description = $subTier->description;
        $copy->group_id = $user->group_id;
        $copy->is_promotional = $subTier->is_promotional;
        $copy->promo_tab_title = $subTier->promo_tab_title;
        $copy->promo_badge = $subTier->promo_badge;
        $copy->discount_percentage = $subTier->discount_percentage;
        $copy->promo_features = $subTier->promo_features;
        $copy->promo_start_at = $subTier->promo_start_at;
        $copy->promo_end_at = $subTier->promo_end_at;
        $copy->save();

        $subTier_pending = new SubscriptionSubTierPending();
        $subTier_pending->subscription_sub_tier_id = $copy->id;
        $subTier_pending->subscription_tier_id = $subTier->subscription_tier_id;
        $subTier_pending->name = $name;
        $subTier_pending->slug = $slug;
        $subTier_pending->description = $subTier->description;
        $subTier_pending->group_id = $user->group_id;
        $subTier_pending->inputer_id = $user->id;
        $subTier_pending->status = 0;
        $subTier_pending->action_type = 'Insert';
        $subTier_pending->is_promotional = $subTier->is_promotional;
        $subTier_pending->promo_tab_title = $subTier->promo_tab_title;
        $subTier_pending->promo_badge = $subTier->promo_badge;
        $subTier_pending->discount_percentage = $subTier->discount_percentage;
        $subTier_pending->promo_features = $subTier->promo_features;
        $subTier_pending->promo_start_at = $subTier->promo_start_at;
        $subTier_pending->promo_end_at = $subTier->promo_end_at;
        $subTier_pending->save();

        $title = 'Please be advised that a new Subscription Sub-Tier (' . $name . ') has been created (duplicated from ' . $subTier->name . ') and is awaiting your review and approval.';
        LogActivity::addToLog(' Subscription Sub-Tier (' . $name . ') duplicated from (' . $subTier->name . ') by ' . $user->name);

        $authorise_email = User::where('id', $request->authorizer_id)->first();
        if ($authorise_email) {
            $this->insertNotifyUsers($name, $title, $authorise_email->email);
        }

        return redirect()->back()->with('success', 'Subscription sub-tier duplicated successfully and pending approval.');
    }

    public function subTierStatus(Request $request, $id)
    {
        $subTier = SubscriptionSubTier::find($id);
        $pending = SubscriptionSubTierPending::where('status', 0)
            ->whereNull('authorizer_id')
            ->where('subscription_sub_tier_id', $id)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$pending) {
            return redirect()->back()->with('error', 'No pending request found for this subscription sub-tier.');
        }

        try {
            return DB::transaction(function () use ($request, $subTier, $pending) {
                if ($request->status == 1) {
                    $this->processSubTierApproval($subTier, $pending);
                    $msg = 'Request approved.';
                } else {
                    $this->processSubTierRejection($request, $subTier, $pending);
                    $msg = 'Request rejected.';
                }

                $this->logAndNotifySubTierSuccess($subTier, $pending, $request->status);

                return redirect()->back()->with('success', $msg);
            });
        } catch (\Exception $e) {
            Log::error('Subscription sub-tier status update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    private function processSubTierApproval($subTier, $pending)
    {
        $pending->status = 1;
        $pending->authorizer_id = Auth::id();
        $pending->save();

        switch ($pending->action_type) {
            case 'Delete':
                $subTier->delete();
                break;
            case 'Edit':
                $subTier->name = $pending->name;
                $subTier->slug = $pending->slug;
                $subTier->subscription_tier_id = $pending->subscription_tier_id;
                $subTier->description = $pending->description;
                $subTier->is_promotional = $pending->is_promotional;
                $subTier->promo_tab_title = $pending->promo_tab_title;
                $subTier->promo_badge = $pending->promo_badge;
                $subTier->discount_percentage = $pending->discount_percentage ?? 0;
                $subTier->promo_features = $pending->promo_features;
                $subTier->promo_start_at = $pending->promo_start_at;
                $subTier->promo_end_at = $pending->promo_end_at;
                $subTier->status = 1;
                $subTier->admin_status = 1;
                $subTier->save();
                break;
            case 'Insert':
                $subTier->is_promotional = $pending->is_promotional;
                $subTier->promo_tab_title = $pending->promo_tab_title;
                $subTier->promo_badge = $pending->promo_badge;
                $subTier->discount_percentage = $pending->discount_percentage ?? 0;
                $subTier->promo_features = $pending->promo_features;
                $subTier->promo_start_at = $pending->promo_start_at;
                $subTier->promo_end_at = $pending->promo_end_at;
                $subTier->status = 1;
                $subTier->admin_status = 1;
                $subTier->save();
                break;
        }
    }

    private function processSubTierRejection($request, $subTier, $pending)
    {
        $pending->status = $request->status;
        $pending->note = $request->note;
        $pending->authorizer_id = Auth::id();
        $pending->save();

        $subTier->note = $request->note;
        $subTier->admin_status = ($pending->action_type == 'Insert') ? $request->status : 1;

        if ($pending->action_type == 'Delete') {
            $subTier->admin_status = 1;
        }

        $subTier->save();
    }

    private function logAndNotifySubTierSuccess($subTier, $pending, $decision)
    {
        $action = $subTier->name;
        $inputter_email = Auth::user()->email;
        $isApprove = ($decision == 1);

        if ($isApprove) {
            $type = ($pending->action_type == 'Insert') ? 'creation' : strtolower($pending->action_type);
            $title = "Subscription Sub-Tier ($action) $type request approved.";
            LogActivity::addToLog(" Subscription Sub-Tier ($action) $type request approved by " . Auth::user()->name);

            if ($pending->action_type == 'Delete') {
                $this->approveNotifyDeletion($action);
            } else {
                $this->approveNotifyUsers($action);
            }
        } else {
            $this->approveNotifyReject($action, $pending->note);
            $type = ($pending->action_type == 'Insert') ? 'creation' : strtolower($pending->action_type);
            $title = "Subscription Sub-Tier ($action) $type request rejected.";
            LogActivity::addToLog(" Subscription Sub-Tier ($action) $type request rejected by " . Auth::user()->name);
        }

        $this->insertNotifyInputter($action, "Please be advised $title", $inputter_email);
    }

    private function insertNotifyUsers($action, $title, $authorise_email)
    {
        try {
            $email_data = [
                'email' => $authorise_email,
                'action' => $action,
                'title' => $title,
            ];

            Mail::to($authorise_email)->queue(new \App\Mail\NotifyUser($email_data));
        } catch (\Exception $e) {
            Log::error('Failed to queue emails for authorisers', ['error' => $e->getMessage()]);
        }
    }

    private function insertNotifyInputter($action, $inputter_title, $inputter_email)
    {
        try {
            $email_data = [
                'email' => $inputter_email,
                'action' => $action,
                'title' => $inputter_title,
            ];

            Mail::to($inputter_email)->queue(new \App\Mail\NotifyUser($email_data));
        } catch (\Exception $e) {
            Log::error('Failed to queue emails for authorisers', ['error' => $e->getMessage()]);
        }
    }

    private function approveNotifyUsers($action)
    {
        try {
            $user = Auth::user();
            $role = 'Super_Administrator_Inputter';

            $inputter = User::where('group_id', $user->group_id)->role($role)->get();
            $title = 'Please be informed the Subscription Sub-Tier (' . $action . ') has been approved.';

            foreach ($inputter as $recipient) {
                Mail::to($recipient->email)->queue(new \App\Mail\NotifyUser([
                    'email' => $recipient->email,
                    'title' => $title,
                    'action' => $action,
                ]));
            }
        } catch (\Exception $e) {
            Log::error('Failed to queue emails for Inputter', ['error' => $e->getMessage()]);
        }
    }

    private function approveNotifyReject($action, $note)
    {
        try {
            $currentUser = Auth::user();
            $role = 'Super_Administrator_Inputter';

            $inputters = User::where('group_id', $currentUser->group_id)->role($role)->get();
            $title = 'Please be advised that the Subscription Sub-Tier (' . e($action) . ') has been rejected and requires your attention.';

            foreach ($inputters as $inputter) {
                Mail::to($inputter->email)->queue(new \App\Mail\NotifyUserApplicationReject([
                    'email' => $inputter->email,
                    'title' => $title,
                    'action' => $action,
                    'note' => $note,
                ]));
            }
        } catch (\Exception $e) {
            Log::error('Failed to queue emails for Inputter', ['error' => $e->getMessage()]);
        }
    }

    private function approveNotifyDeletion($action)
    {
        try {
            $user = Auth::user();
            $role = 'Super_Administrator_Inputter';

            $inputter = User::where('group_id', $user->group_id)->role($role)->get();
            $title = 'Please be informed the Subscription Sub-Tier (' . $action . ') has been deleted.';

            foreach ($inputter as $recipient) {
                Mail::to($recipient->email)->queue(new \App\Mail\NotifyUser([
                    'email' => $recipient->email,
                    'title' => $title,
                    'action' => $action,
                ]));
            }
        } catch (\Exception $e) {
            Log::error('Failed to queue emails for Inputter', ['error' => $e->getMessage()]);
        }
    }
}
