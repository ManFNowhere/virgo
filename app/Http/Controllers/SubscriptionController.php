<?php

namespace App\Http\Controllers;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Price;
use Stripe\Subscription;
use Carbon\Carbon;
class SubscriptionController extends Controller
{
    public function subscription(Request $request)
    {
        $type = (int) $request->type;

        if ($request->user()->isDemoAccount()) {
            if (in_array($type, [0, 1, 2], true)) {
                $request->user()->update(['role' => $type]);
            }
            return redirect()->route('dashboard')->with('status', 'plan-updated');
        }

        if (! env('STRIPE_SECRET')) {
            return redirect()->route('subscription')->with('demo', 'Demo mode: payments are disabled on this server.');
        }
        $monthlyPlan = env('STRIPE_MONTHLY');
        $yearlyPlan = env('STRIPE_YEARLY');
        $plan = ($request->type == 2) ? $yearlyPlan : $monthlyPlan;
        if ($request->type == 0) {
            return redirect()->route('dashboard');
        }
        $sub = \App\Models\Subscription::where('user_id', Auth::id())->where('stripe_status', 'canceled')->first();
        $user = Auth::user();

        if ($sub) {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            if ($sub->ends_at != null) {
                if ($user->role == $request->type) {
                    Subscription::update($sub->stripe_id, ['cancel_at_period_end'=>false]);
                } else {
                    // Start new subscription after the current plan ends need fix
                    // $user->subscription()->swap($plan);
                    return $request->user()
                ->newSubscription(env('STRIPE_PRODUCT'), $plan)
                ->checkout([
                    'success_url' => route('success.subscription', ['type' => $request->type]),
                    'cancel_url' => route('dashboard'),
                ]);
                }
            }
        } else {
            // Create a new subscription
            return $request->user()
                ->newSubscription(env('STRIPE_PRODUCT'), $plan)
                ->checkout([
                    'success_url' => route('success.subscription', ['type' => $request->type]),
                    'cancel_url' => route('dashboard'),
                ]);
        }
    
        return redirect()->route('dashboard');
    }

    public function success($type){
        $user = auth()->user();
        // Only upgrade the role when the Stripe subscription is really active
        if (! in_array((int) $type, [1, 2], true) || ! $user->subscribed(env('STRIPE_PRODUCT'))) {
            return redirect()->route('subscription');
        }
        $user->update(['role'=>(int) $type]);
        return view('subscription.success');
    }

    public function cancel(){
        if (! env('STRIPE_SECRET')) {
            // Mode demo: Stripe tidak dikonfigurasi, tampilkan halaman saja
            return redirect()->route('subscription')->with('demo', 'Demo mode: payments are disabled on this server.');
        }
        $user = auth()->user();
        $subscription = \App\Models\Subscription::where('user_id', $user->id)->where('stripe_status', 'active')->firstOrFail();
        $subscriptionId = $subscription->stripe_id;
        $productId = $subscription->stripe_price;
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $product = Price::retrieve($productId);
        if($product->id==env('STRIPE_MONTHLY')){
            $date = Carbon::createFromTimestamp($product->created)->addMonth()->toDateString();
        }else{$date = Carbon::createFromTimestamp($product->created)->addYear()->toDateString();}       

        return view('subscription.cancel',['id'=>$subscriptionId,'product'=>$product, 'date'=>$date]);
    }
    public function cancelSubscription($subscriptionId){
        // Only allow cancelling a subscription that belongs to the current user
        \App\Models\Subscription::where('user_id', auth()->id())->where('stripe_id', $subscriptionId)->firstOrFail();
        if (! env('STRIPE_SECRET')) {
            // Mode demo: Stripe tidak dikonfigurasi, tampilkan halaman saja
            return redirect()->route('subscription')->with('demo', 'Demo mode: payments are disabled on this server.');
        }
        Stripe::setApiKey(env('STRIPE_SECRET'));
        // // cancle at end of subscription
        // Subscription::update($subscriptionId, ['cancel_at_period_end'=>true]);

        // // cancel on current time
        // $sub = Subscription::retrieve($subscriptionId)->cancel();
        // $id = auth()->user()->id;
        // User::find($id)->update(['role'=>0]);


        // cancel on specific time
        $time = Carbon::now()->addMinutes(1)->timestamp;
        Subscription::update($subscriptionId, ['cancel_at'=>$time]);
        return redirect('/dashboard');
    }
}
