<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Category;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionTier;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        $academicTier = SubscriptionTier::where('status', 1)
            ->where(function ($q) {
                $q->where('name', 'like', '%Academic%')
                  ->orWhere('slug', 'like', '%academic%');
            })
            ->with(['subTiers' => function ($query) {
                $query->where('status', 1)->orderBy('id');
            }, 'subTiers.plans' => function ($query) {
                $query->where('status', 1)->orderBy('duration');
            }])
            ->first();

        if (!$academicTier) {
            $academicTier = SubscriptionTier::where('status', 1)
                ->whereHas('subTiers', function ($q) {
                    $q->where('name', 'like', '%Academic%');
                })
                ->with(['subTiers' => function ($query) {
                    $query->where('status', 1)->orderBy('id');
                }, 'subTiers.plans' => function ($query) {
                    $query->where('status', 1)->orderBy('duration');
                }])
                ->first();
        }

        $academicSubTierIds = $academicTier ? $academicTier->subTiers->pluck('id')->toArray() : [];

        $institutionalPlans = SubscriptionPlan::where('status', 1)
            ->where(function ($query) use ($academicSubTierIds) {
                $query->whereNull('subscription_sub_tier_id');
                if (!empty($academicSubTierIds)) {
                    $query->orWhere(function ($q2) use ($academicSubTierIds) {
                        $q2->whereNotNull('subscription_sub_tier_id')
                           ->whereNotIn('subscription_sub_tier_id', $academicSubTierIds);
                    });
                }
            })
            ->with(['subTier.tier'])
            ->orderBy('duration')
            ->get();

        $promotionalTiers = SubscriptionTier::where('status', 1)
            ->where('is_promotional', 1)
            ->where(function ($q) {
                $q->whereNull('promo_start_at')->orWhere('promo_start_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('promo_end_at')->orWhere('promo_end_at', '>=', now());
            })
            ->with(['subTiers' => function ($query) {
                $query->where('status', 1)->orderBy('id');
            }, 'subTiers.plans' => function ($query) {
                $query->where('status', 1)->orderBy('duration');
            }])
            ->get();

        $data = Category::where('status', 1)->get();
        $subscriptionPlans = SubscriptionPlan::all();
        $news_alert = News::orderBy('created_at', 'desc')->where('status', 1)->get();
        $marketProductTags = \App\Models\MarketProductTag::where('status', 1)
            ->where('admin_status', 1)
            ->orderBy('name')
            ->get();

        // Initialize userSubscription and activeSubscription to null
        $userSubscription = null;
        $activeSubscription = null;

        // Check if the user is logged in and get the latest active subscription plan
        if (Auth::check()) {
            $user = Auth::user();
            $today = Carbon::now();

            $activeSubscription = Subscription::with('subscriptionPlan')
                ->where('user_id', $user->id)
                ->where('status', 1)
                ->where('end_date', '>=', $today)
                ->latest('id')
                ->first();

            $userSubscription = $activeSubscription ? true : false;
        }

        return view('welcome', compact('data', 'news_alert', 'subscriptionPlans', 'institutionalPlans', 'academicTier', 'promotionalTiers', 'userSubscription', 'activeSubscription', 'marketProductTags'));
    }



    public function newsalert(Request $request)
    {


        $data = Category::where('status', 1)->get();
        $subscriptionPlans = SubscriptionPlan::all();
        $news_alert = News::orderBy('created_at', 'desc')->where('status', 1)->get();
        $marketProductTags = \App\Models\MarketProductTag::where('status', 1)
            ->where('admin_status', 1)
            ->orderBy('name')
            ->get();

        // Initialize userSubscription to null
        $userSubscription = null;

        //$news_alert = News::paginate(15);

        // Check if the user is logged in and get the latest active subscription plan
        if (Auth::check()) {
            $user = Auth::user();
            $today = Carbon::now();

            $userSubscription = Subscription::where('user_id', $user->id)
                ->where('status', 1)
                ->where('end_date', '>=', $today) // Check if the end_date is greater than or equal to today
                ->exists();
            // $userSubscription = Subscription::where('user_id', $user->id)->latest('created_at')->first();
        }


        return view('news', compact('data', 'news_alert', 'subscriptionPlans', 'userSubscription', 'marketProductTags'));
    }



    public function alert(Request $request, $id)
    {

        $data = Category::where('status', 1)->get();
        $subscriptionPlans = SubscriptionPlan::all();
        $news_alert = News::orderBy('created_at', 'desc')->where('status', 1)->get();

        // Initialize userSubscription to null
        $userSubscription = null;

        //$news_alert = News::paginate(15);

        // Check if the user is logged in and get the latest active subscription plan
        if (Auth::check()) {
            $user = Auth::user();
            $today = Carbon::now();

            $userSubscription = Subscription::where('user_id', $user->id)
                ->where('status', 1)
                ->where('end_date', '>=', $today) // Check if the end_date is greater than or equal to today
                ->exists();
            // $userSubscription = Subscription::where('user_id', $user->id)->latest('created_at')->first();
        }




        // return $id;
        $data = Category::where('status', 1)->get();
        $single_news = News::where('id', $id)->first();
        $news_alert = News::where('status', 1)->get();
        $other_news = News::where('status', 1)->orderBy('created_at', 'desc')->limit(5)->get();
        $marketProductTags = \App\Models\MarketProductTag::where('status', 1)
            ->where('admin_status', 1)
            ->orderBy('name')
            ->get();
        return view('alert', compact('single_news', 'news_alert', 'other_news', 'data', 'subscriptionPlans', 'userSubscription', 'marketProductTags'));
    }


    public function feedback(Request $request)
    {


        // $data = Category::all();
        // $news_alert = News::limit(2)->get();


        return view('contact');
    }

    // public function alert(Request $id)
    // {


    //     return   $news_alert = News::where('id', $id)->get();


    //     return view('alert', compact('news_alert'));
    // }


    public function feedback_post(Request $request)
    {

        $this->validate($request, [
            'fname' => ['required'],
            'lname' => ['required'],
            'email' => ['required'],
            'subject' => ['required'],
            'feedback' => ['required'],
            'institution' => ['required'],
            'member_status' => ['nullable', 'string'],
        ]);


        // return $request;
        $email_data = array(
            'fname' => $request['fname'],
            'lname' => $request['lname'],
            'email' => $request['email'],
            'subject' => $request['subject'],
            'feedback' => $request['feedback'],
            'institution' => $request['institution'],
            'member_status' => $request['member_status'],
        );
        
        try {
            // Save feedback to the database
            Feedback::create([
                'fname' => $request['fname'],
                'lname' => $request['lname'],
                'email' => $request['email'],
                'subject' => $request['subject'],
                'feedback' => $request['feedback'],
                'institution' => $request['institution'],
                'member_status' => $request['member_status'],
            ]);

            Mail::send('emails.feedbackemail', $email_data, function ($message) use ($email_data) {
                // Add your additional email addresses to this array
                $recipients = array_filter(array_map('trim', explode(',', env('FEEDBACK_RECIPIENTS'))));
                $message->to($recipients)
                    ->replyTo($email_data['email'])
                    ->subject('New Feedback Received: ' . $email_data['subject'])
                    ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));

            });

            return redirect()->back()->with('success', 'Thank you for your Feedback.');
        } catch (\Exception $e) {
            // Log::error('Feedback email failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Sorry, we encountered a technical issue sending your feedback. Please try again later.');
        }
    }





    public function success_pay(Request $request)
    {
        if (!Session::has('success')) {
            return redirect()->route('home');
        }

        return view('success');
    }



    public function subscribe(Request $request)
    {
        $previousUrl = url()->previous();

        Session::put('previous_url', $previousUrl);

        $getorevioysUrl = Session::get('previous_url');

        $academicTier = SubscriptionTier::where('status', 1)
            ->where(function ($q) {
                $q->where('name', 'like', '%Academic%')
                  ->orWhere('slug', 'like', '%academic%');
            })
            ->with(['subTiers' => function ($query) {
                $query->where('status', 1)->orderBy('id');
            }, 'subTiers.plans' => function ($query) {
                $query->where('status', 1)->orderBy('duration');
            }])
            ->first();

        if (!$academicTier) {
            $academicTier = SubscriptionTier::where('status', 1)
                ->whereHas('subTiers', function ($q) {
                    $q->where('name', 'like', '%Academic%');
                })
                ->with(['subTiers' => function ($query) {
                    $query->where('status', 1)->orderBy('id');
                }, 'subTiers.plans' => function ($query) {
                    $query->where('status', 1)->orderBy('duration');
                }])
                ->first();
        }

        $academicSubTierIds = $academicTier ? $academicTier->subTiers->pluck('id')->toArray() : [];

        $institutionalPlans = SubscriptionPlan::where('status', 1)
            ->where(function ($query) use ($academicSubTierIds) {
                $query->whereNull('subscription_sub_tier_id');
                if (!empty($academicSubTierIds)) {
                    $query->orWhere(function ($q2) use ($academicSubTierIds) {
                        $q2->whereNotNull('subscription_sub_tier_id')
                           ->whereNotIn('subscription_sub_tier_id', $academicSubTierIds);
                    });
                }
            })
            ->with(['subTier.tier'])
            ->orderBy('duration')
            ->get();

        $promotionalTiers = SubscriptionTier::where('status', 1)
            ->where('is_promotional', 1)
            ->where(function ($q) {
                $q->whereNull('promo_start_at')->orWhere('promo_start_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('promo_end_at')->orWhere('promo_end_at', '>=', now());
            })
            ->with(['subTiers' => function ($query) {
                $query->where('status', 1)->orderBy('id');
            }, 'subTiers.plans' => function ($query) {
                $query->where('status', 1)->orderBy('duration');
            }])
            ->get();

        // Initialize userSubscription and activeSubscription to null
        $userSubscription = null;
        $activeSubscription = null;

        // Check if the user is logged in and get the latest active subscription plan
        if (Auth::check()) {
            $user = Auth::user();
            $today = Carbon::now();

            $activeSubscription = Subscription::with('subscriptionPlan')
                ->where('user_id', $user->id)
                ->where('status', 1)
                ->where('end_date', '>=', $today) // Check if the end_date is greater than or equal to today
                ->latest('id')
                ->first();

            $userSubscription = $activeSubscription ? true : false;
        }

        return view('subscribe', compact('institutionalPlans', 'academicTier', 'promotionalTiers', 'userSubscription', 'activeSubscription'));
    }
}
