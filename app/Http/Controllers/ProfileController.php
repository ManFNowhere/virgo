<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Stripe\Stripe;
use Stripe\Price;
use Stripe\Product;
class ProfileController extends Controller
{
    /**
     * Collect the current subscription details for the logged-in user.
     */
    private function subscriptionData(): array
    {
        $user = auth()->user();
        $product = null;
        $date = null;
        $subscription = Subscription::where('user_id', $user->id)->where('stripe_status', 'active')->first();

        if ($subscription != null && env('STRIPE_SECRET')) {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $product = Price::retrieve($subscription->stripe_price);
            $created = Carbon::createFromTimestamp($product->created);
            $date = ($product->id == env('STRIPE_MONTHLY') ? $created->addMonth() : $created->addYear())->toDateString();
        }

        return [
            'user'         => $user,
            'subscription' => $subscription,
            'product'      => $product,
            'date'         => $date,
            'settings'     => \App\Models\Setting::pluck('value', 'key'),
        ];
    }

    /**
     * Show the dashboard with the user's subscription.
     */
    public function index(): View
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            $movies   = \App\Models\Movie::latest()->get();
            $genres   = \App\Models\Genre::all();
            $settings = \App\Models\Setting::pluck('value', 'key');
            return view('dashboard.admin', compact('user', 'movies', 'genres', 'settings'));
        }

        return view('dashboard.viewer', $this->subscriptionData());
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        if ($request->user()->isDemoAccount()) {
            return back()->withErrors(['name' => 'Profile changes are disabled on demo accounts.'])->withInput();
        }

        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        $request->user()->save();

        return back()->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        if ($request->user()->isDemoAccount()) {
            return back()->with('demo_error', 'Account deletion is disabled on demo accounts.');
        }

        $request->validate([
            'delete_password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

   
}
