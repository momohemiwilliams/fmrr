<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Subscription;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Auth;
use App\Services\PaymentService;

class SubscriptionController extends Controller
{


    public function subscribe_payment(Request $request, PaymentService $paymentService)
    {
        $plan = SubscriptionPlan::findOrFail($request->plan_id);
        $user = Auth::user();
        $currency = $request->input('currency', 'NGN');

        // Check if user currently has an active subscription to this same plan
        $hasActiveSamePlan = Subscription::where('user_id', $user->id)
            ->where('subscription_plan_id', $plan->id)
            ->where('status', 1)
            ->where('end_date', '>=', Carbon::now())
            ->exists();

        if ($hasActiveSamePlan) {
            return redirect()->back()->with('error', 'You currently have an active subscription to this plan. You can only subscribe to a different plan.');
        }

        // Subscribing to an Academic Subscription mandates completing an academic onboarding profile and verification
        if ($plan->requiresAcademicVerification()) {
            if (!$user->hasVerifiedAcademicAffiliation()) {
                if ($user->hasPendingAcademicVerification()) {
                    return redirect()->route('subscribe')->with('error', 'Your academic onboarding profile and affiliation verification request is currently awaiting administrator review. You will be able to complete your subscription once approved.');
                }

                return redirect()->route('studentVerification.apply', ['plan_id' => $plan->id])
                    ->with('error', 'Subscribing to an Academic Subscription mandates completing an academic onboarding profile (Institution Name, Faculty/Department, User Role, Institutional Email, and ID proof). Please complete the onboarding step to proceed.');
            }
        }

        // Create subscription record
        $startDate = Carbon::now();
        $endDate = $startDate->copy()->addDays($plan->duration);

        $subscription = new Subscription();
        $subscription->user_id = $user->id;
        $subscription->subscription_plan_id = $plan->id;
        $subscription->start_date = $startDate;
        $subscription->end_date = $endDate;
        $subscription->save();

        // Create transaction record
        $transaction = $paymentService->createTransaction($user, $plan, $currency);

        // Generate payment URL using PaymentService
        $paymentUrl = $paymentService->createSubscriptionPayment($user, $plan, $currency);
        
        return redirect($paymentUrl);
    }

}


