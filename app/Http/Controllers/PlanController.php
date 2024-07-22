<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\UserPlan;
use App\Models\PlanSubscription;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function pricing(Request $request)
    {
        $plan_subscription = $request->session()->get('plan_subscription');

        $flash = $request->session()->get('flash', ['message' => null]);

        $plans = Plan::all();

        $user_plan = UserPlan::query()
            ->with('plan')
            ->where('user_id', auth()->id())
            ->first();

        return inertia('Plan/Pricing', [
            'plan_subscription' => $plan_subscription,
            'flash' => $flash,
            'plans' => $plans,
            'user_plan' => $user_plan,
            'razorpay_key' => env("RAZORPAY_KEY_ID"),
        ]);
    }

    public function info(Request $request)
    {
        $user_plan = UserPlan::query()
            ->with('plan')
            ->where('user_id', auth()->id())
            ->first();

        $plan_subscriptions = PlanSubscription::query()
            ->with('plan')
            ->where('user_id', auth()->id())
            ->get();

        return inertia('Plan/Info', [
            'user_plan' => $user_plan,
            'plan_subscriptions' => $plan_subscriptions,
        ]);
    }
}
