<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\PlanSubscription;
use App\Models\User;
use App\Models\UserPlan;
use App\Repositories\PaymentTransactionRepositoryInterface;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PlanSubscriptionController extends Controller
{
    public function __construct(public PaymentTransactionRepositoryInterface $paymentTransactionRepositoryInterface)
    {
        //
    }

    public function store(Request $request)
    {
        $user = User::query()
            ->with(['user_plan'])
            ->whereId(auth()->id())
            ->first();

        $plan = Plan::find($request->plan_id);

        $downgrading = $user->user_plan->is_downgrading($plan);

        if ($downgrading && $user->user_plan->is_active()) {
            return redirect()
                ->route('pricing')
                ->with([
                    'plan_subscription' => null,
                    'flash' => ['message' => "You can only downgrade after plan is expired."]
                ]);
        }

        $plan_subscription = PlanSubscription::query()
            ->where([
                'user_id' => auth()->id(),
                'plan_id' => $plan->id,
                'status' => "created",
            ])
            ->first();

        if ($plan_subscription) {
            $order = $this->paymentTransactionRepositoryInterface->get_order_by_id("test");

            if (!isset($order['id'])) {
                $order = $this->paymentTransactionRepositoryInterface->create_order([
                    'amount' => (int) $plan->monthly_charges * 100,
                    'currency' => $plan->currency,
                    'receipt' => Str::random(32),
                ]);
            }
        } else {
            $order = $this->paymentTransactionRepositoryInterface->create_order([
                'amount' => (int) $plan->monthly_charges * 100,
                'currency' => $plan->currency,
                'receipt' => Str::random(32),
            ]);

            $plan_subscription = PlanSubscription::create([
                'user_id' => auth()->id(),
                'plan_id' => $plan->id,
                'order_id' => $order['id'],
                'amount' => $plan->monthly_charges,
            ]);
        }

        return redirect()
            ->route('pricing')
            ->with([
                'flash' => ['message' => null],
                'plan_subscription' => $plan_subscription
            ]);
    }

    public function process(Request $request)
    {
        $payload = "$request->razorpay_order_id|$request->razorpay_payment_id";

        $secret = config('services.razorpay.secret');

        $hash = hash_hmac('sha256', $payload, $secret);

        if ($hash !== $request->razorpay_signature) {
            throw new Error('Invalid request');
        }

        $plan_subscription = PlanSubscription::query()
            ->where(['user_id' => auth()->id(), 'order_id' => $request->razorpay_order_id])
            ->first();

        $plan_subscription->status = 'paid';

        $plan_subscription->save();

        UserPlan::query()
            ->where(['user_id' => auth()->id()])
            ->update(['plan_id' => $request->plan_id, 'expires_at' => now()->addMonth(1)]);

        return redirect()
            ->route('plan.info')
            ->with([
                'flash' => ['message' => null],
                'plan_subscription' => $plan_subscription
            ]);
    }
}
