@extends('layouts.app')

@section('container')
<div class="min-h-screen bg-surface pt-20 pb-10 px-4 sm:px-8">
    <div class="max-w-2xl mx-auto space-y-6">

        <!-- Header -->
        <div>
            <h1 class="text-content-primary text-2xl font-bold">My Account</h1>
            <p class="text-content-muted text-sm mt-1">Manage your profile and subscription.</p>
        </div>

        <!-- Alerts -->
        @if (session('status') === 'profile-updated')
        <div class="flex items-center gap-3 bg-green-900/40 border border-green-700 text-green-400 text-sm rounded-xl px-4 py-3">
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            Profile updated successfully.
        </div>
        @endif

        @if (session('status') === 'plan-updated')
        <div class="flex items-center gap-3 bg-green-900/40 border border-green-700 text-green-400 text-sm rounded-xl px-4 py-3">
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            Subscription plan updated.
        </div>
        @endif

        @if (session('demo_error'))
        <div class="flex items-center gap-3 bg-yellow-900/40 border border-yellow-700 text-yellow-400 text-sm rounded-xl px-4 py-3">
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            {{ session('demo_error') }}
        </div>
        @endif

        @if ($errors->has('name'))
        <div class="flex items-center gap-3 bg-red-900/40 border border-red-700 text-red-400 text-sm rounded-xl px-4 py-3">
            {{ $errors->first('name') }}
        </div>
        @endif

        @if ($user->isDemoAccount())
        <div class="flex items-center gap-3 bg-surface-raised border border-surface-border text-content-muted text-sm rounded-xl px-4 py-3">
            <svg class="w-4 h-4 flex-shrink-0 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            Demo account — profile changes and account deletion are disabled.
        </div>
        @endif

        <!-- Subscription Card -->
        <div class="bg-surface-card border border-surface-border rounded-2xl overflow-hidden">
            <div class="px-6 py-4 border-b border-surface-border">
                <h2 class="text-content-primary font-semibold">Subscription</h2>
            </div>
            <div class="p-6">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-brand/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3l14 9-14 9V3z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-content-primary font-semibold text-lg">{{ $user->tierLabel() }} Plan</p>
                            @if ($product != null)
                                <p class="text-content-muted text-xs mt-0.5">
                                    {{ $subscription && $subscription->ends_at != null ? 'Cancels on ' : 'Renews on ' }}
                                    <span class="text-content-secondary">{{ $date }}</span>
                                </p>
                            @else
                                <p class="text-content-muted text-xs mt-0.5">Watching free content only.</p>
                            @endif
                        </div>
                    </div>
                    <div class="flex gap-2 flex-wrap">
                        @if ($user->role == 0)
                            <button id="open-plan-modal"
                                    class="bg-brand hover:bg-brand-dark text-white text-sm font-medium px-4 py-2 rounded-xl transition">
                                Upgrade
                            </button>
                        @elseif ($subscription && $subscription->ends_at != null)
                            <button id="open-plan-modal"
                                    class="bg-surface-raised hover:bg-surface-border text-content-secondary text-sm font-medium px-4 py-2 rounded-xl transition">
                                Manage
                            </button>
                        @else
                            <button id="open-plan-modal"
                                    class="bg-surface-raised hover:bg-surface-border text-content-secondary text-sm font-medium px-4 py-2 rounded-xl transition">
                                Change Plan
                            </button>
                            @if ($subscription)
                            <a href="{{ route('cancel.subscription', ['id' => $subscription->stripe_id]) }}"
                               class="bg-red-900/40 hover:bg-red-900/60 text-red-400 border border-red-800 text-sm font-medium px-4 py-2 rounded-xl transition">
                                Cancel
                            </a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Info -->
        <div class="bg-surface-card border border-surface-border rounded-2xl overflow-hidden">
            <div class="px-6 py-4 border-b border-surface-border flex items-center justify-between">
                <h2 class="text-content-primary font-semibold">Profile</h2>
                @if ($user->isDemoAccount())
                    <span class="text-xs bg-surface-raised text-content-muted border border-surface-border px-2 py-0.5 rounded-full">Demo — locked</span>
                @endif
            </div>
            <form action="{{ route('profile.update') }}" method="post" class="p-6 space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <label for="name" class="block text-content-secondary text-xs font-medium mb-1.5">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                           @if ($user->isDemoAccount()) disabled @endif
                           class="w-full border border-surface-border text-sm rounded-xl px-4 py-3 outline-none transition
                                  {{ $user->isDemoAccount() ? 'bg-surface-raised text-content-muted cursor-not-allowed' : 'bg-surface text-content-primary focus:border-brand focus:ring-1 focus:ring-brand' }}"
                           required>
                </div>

                <div>
                    <label class="block text-content-secondary text-xs font-medium mb-1.5">Email address</label>
                    <input type="email" value="{{ $user->email }}" disabled
                           class="w-full bg-surface-raised border border-surface-border text-content-muted text-sm rounded-xl px-4 py-3 cursor-not-allowed">
                    <p class="text-content-muted text-xs mt-1">Email cannot be changed.</p>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit"
                            @if ($user->isDemoAccount()) disabled @endif
                            class="text-sm font-medium px-5 py-2.5 rounded-xl transition
                                   {{ $user->isDemoAccount() ? 'bg-brand/40 text-white/40 cursor-not-allowed' : 'bg-brand hover:bg-brand-dark text-white' }}">
                        Save changes
                    </button>
                </div>
            </form>
        </div>

        <!-- Password -->
        <div class="bg-surface-card border border-surface-border rounded-2xl overflow-hidden">
            <div class="px-6 py-4 border-b border-surface-border flex items-center justify-between">
                <h2 class="text-content-primary font-semibold">Password</h2>
                <span class="text-xs bg-surface-raised text-content-muted border border-surface-border px-2 py-0.5 rounded-full">Demo — locked</span>
            </div>
            <div class="p-6 space-y-4 opacity-50 pointer-events-none select-none">
                <div>
                    <label class="block text-content-secondary text-xs font-medium mb-1.5">Current password</label>
                    <input type="password" disabled placeholder="••••••••"
                           class="w-full bg-surface border border-surface-border text-content-muted text-sm rounded-xl px-4 py-3 cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-content-secondary text-xs font-medium mb-1.5">New password</label>
                    <input type="password" disabled placeholder="••••••••"
                           class="w-full bg-surface border border-surface-border text-content-muted text-sm rounded-xl px-4 py-3 cursor-not-allowed">
                </div>
                <div class="flex justify-end pt-2">
                    <button disabled class="bg-brand/50 text-white/50 text-sm font-medium px-5 py-2.5 rounded-xl cursor-not-allowed">
                        Update password
                    </button>
                </div>
            </div>
            <div class="px-6 pb-5">
                <p class="text-content-muted text-xs">Password changes are disabled on demo accounts.</p>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="bg-surface-card border border-red-900/50 rounded-2xl overflow-hidden">
            <div class="px-6 py-4 border-b border-red-900/50">
                <h2 class="text-red-400 font-semibold">Danger Zone</h2>
            </div>
            <div class="p-6">
                <p class="text-content-secondary text-sm mb-4">Permanently delete your account and all associated data.</p>
                @if ($user->isDemoAccount())
                    <button disabled
                            class="bg-red-900/20 text-red-400/40 border border-red-900/40 text-sm font-medium px-4 py-2 rounded-xl cursor-not-allowed">
                        Delete account
                    </button>
                    <p class="text-content-muted text-xs mt-2">Account deletion is disabled on demo accounts.</p>
                @else
                    <button id="open-delete-modal"
                            class="bg-red-900/40 hover:bg-red-900/60 text-red-400 border border-red-800 text-sm font-medium px-4 py-2 rounded-xl transition">
                        Delete account
                    </button>
                @endif
            </div>
        </div>

        <!-- Logout -->
        <div class="flex md:justify-end w-full">
            <form action="{{ url('/logout') }}" method="post">
                @csrf
                <button type="submit" class="text-white hover:text-red-300 text-sm transition bg-red-500 hover:bg-red-400 py-2 px-4 w-full mx-auto rounded-md">
                    Sign Out
                </button>
            </form>
        </div>

    </div>
</div>

<!-- Delete Account Modal -->
@if (!$user->isDemoAccount())
<div id="delete-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" id="delete-overlay"></div>
    <div class="relative bg-surface-card border border-red-900/50 rounded-2xl w-full max-w-md shadow-2xl p-6">
        <h3 class="text-content-primary font-semibold text-lg mb-2">Delete account?</h3>
        <p class="text-content-secondary text-sm mb-5">This cannot be undone. Enter your password to confirm.</p>
        <form action="{{ route('profile.destroy') }}" method="post" class="space-y-4">
            @csrf
            <input type="password" name="delete_password" placeholder="Your password"
                   class="w-full bg-surface border border-surface-border text-content-primary text-sm rounded-xl px-4 py-3 outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 placeholder-content-muted transition" required>
            <div class="flex gap-3 justify-end">
                <button type="button" id="close-delete-modal"
                        class="text-content-secondary hover:text-content-primary text-sm font-medium px-4 py-2 rounded-xl bg-surface-raised transition">
                    Cancel
                </button>
                <button type="submit"
                        class="bg-red-700 hover:bg-red-600 text-white text-sm font-medium px-4 py-2 rounded-xl transition">
                    Delete
                </button>
            </div>
        </form>
    </div>
</div>
@endif

<!-- Subscription Plan Modal -->
<div id="plan-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" id="plan-overlay"></div>
    <div class="relative bg-surface-card border border-surface-border rounded-2xl w-full max-w-2xl shadow-2xl overflow-hidden">

        <div class="flex items-center justify-between px-6 py-5 border-b border-surface-border">
            <div>
                <h2 class="text-content-primary font-bold text-xl">Choose a Plan</h2>
                <p class="text-content-muted text-xs mt-0.5">Select the plan that works for you.</p>
            </div>
            <button id="close-plan-modal" class="text-content-muted hover:text-content-primary transition p-1 rounded-lg hover:bg-surface-raised">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form action="{{ route('post.subscription') }}" method="post" class="p-6">
            @csrf
            <input type="hidden" name="type" id="plan-type" value="{{ $user->role }}">

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

                <!-- Free -->
                <div data-plan="0"
                     class="plan-card relative cursor-pointer border rounded-2xl p-5 transition-all duration-200
                            {{ $user->role == 0 ? 'border-brand bg-brand/10 ring-1 ring-brand' : 'border-surface-border bg-surface hover:border-brand/40' }}">
                    @if ($user->role == 0)
                        <div class="absolute top-3 right-3 w-5 h-5 bg-brand rounded-full flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    @endif
                    <p class="text-content-primary font-semibold text-sm mb-1">Free</p>
                    <div class="mt-4 mb-4">
                        <span class="text-content-primary font-bold text-3xl">$0</span>
                        <span class="text-content-muted text-xs">/mo</span>
                    </div>
                    <ul class="space-y-1.5 text-content-secondary text-xs">
                        <li class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Free movies
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-content-muted flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                            No premium
                        </li>
                    </ul>
                    @if ($user->role == 0)
                        <span class="text-xs bg-brand/20 text-brand px-2 py-0.5 rounded-full font-medium">Current</span>
                    @endif
                </div>

                <!-- Monthly -->
                <div data-plan="1"
                     class="plan-card relative cursor-pointer border rounded-2xl p-5 transition-all duration-200
                            {{ $user->role == 1 ? 'border-brand bg-brand/10 ring-1 ring-brand' : 'border-surface-border bg-surface hover:border-brand/40' }}">
                    @if ($user->role == 1)
                        <div class="absolute top-3 right-3 w-5 h-5 bg-brand rounded-full flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    @endif
                    <p class="text-content-primary font-semibold text-sm mb-1">{{ $settings->get('monthly_label', 'Monthly') }}</p>
                    <div class="mt-4 mb-4">
                        <span class="text-content-primary font-bold text-3xl">{{ $settings->get('monthly_price', '4.99') }}</span>
                        <span class="text-content-muted text-xs">/mo</span>
                    </div>
                    <ul class="space-y-1.5 text-content-secondary text-xs">
                        <li class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            All movies
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Cancel anytime
                        </li>
                    </ul>
                    @if ($user->role == 1)
                        <span class="text-xs bg-brand/20 text-brand px-2 py-0.5 rounded-full font-medium">Current</span>
                    @endif
                </div>

                <!-- Yearly -->
                <div data-plan="2"
                     class="plan-card relative cursor-pointer border rounded-2xl p-5 transition-all duration-200
                            {{ $user->role == 2 ? 'border-brand bg-brand/10 ring-1 ring-brand' : 'border-surface-border bg-surface hover:border-brand/40' }}">
                    @if ($user->role == 2)
                        <div class="absolute top-3 right-3 w-5 h-5 bg-brand rounded-full flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    @endif
                    <div class="flex items-start justify-between mb-1">
                        <p class="text-content-primary font-semibold text-sm">{{ $settings->get('yearly_label', 'Yearly') }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <span class="text-content-primary font-bold text-3xl">{{ $settings->get('yearly_price', '49.99') }}</span>
                        <span class="text-content-muted text-xs">/yr</span>
                    </div>
                    <ul class="space-y-1.5 text-content-secondary text-xs">
                        <li class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            All movies
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Save vs monthly
                        </li>
                    </ul>
                    <span class="inline-block text-xs bg-green-900/50 text-green-400 border border-green-800/60 px-2 py-0.5 rounded-full mb-3">Best value</span>
                    @if ($user->role == 2)
                        <div class="mb-2"><span class="text-xs bg-brand/20 text-brand px-2 py-0.5 rounded-full font-medium">Current</span></div>
                    @endif
                </div>

            </div>

            <div class="flex gap-3 justify-end">
                <button type="button" id="close-plan-modal-2"
                        class="text-content-secondary hover:text-content-primary text-sm font-medium px-5 py-2.5 rounded-xl bg-surface-raised transition">
                    Cancel
                </button>
                <button type="submit"
                        class="bg-brand hover:bg-brand-dark text-white text-sm font-medium px-6 py-2.5 rounded-xl transition">
                    Select Plan
                </button>
            </div>
        </form>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // ── Delete modal ──────────────────────────────────────────
        const deleteModal = document.getElementById('delete-modal');
        if (deleteModal) {
            const deleteOverlay = document.getElementById('delete-overlay');
            const openDelete    = document.getElementById('open-delete-modal');
            const closeDelete   = document.getElementById('close-delete-modal');

            const openDel  = () => { deleteModal.classList.remove('hidden'); document.body.style.overflow = 'hidden'; };
            const closeDel = () => { deleteModal.classList.add('hidden');    document.body.style.overflow = ''; };

            openDelete.addEventListener('click', openDel);
            closeDelete.addEventListener('click', closeDel);
            deleteOverlay.addEventListener('click', closeDel);
        }

        // ── Plan modal ────────────────────────────────────────────
        const planModal    = document.getElementById('plan-modal');
        const planOverlay  = document.getElementById('plan-overlay');
        const openPlanBtn  = document.getElementById('open-plan-modal');
        const closePlan1   = document.getElementById('close-plan-modal');
        const closePlan2   = document.getElementById('close-plan-modal-2');
        const planType     = document.getElementById('plan-type');
        const planCards    = document.querySelectorAll('.plan-card');

        const openPlan  = () => { planModal.classList.remove('hidden'); document.body.style.overflow = 'hidden'; };
        const closePlan = () => { planModal.classList.add('hidden');    document.body.style.overflow = ''; };

        if (openPlanBtn) {
            openPlanBtn.addEventListener('click', openPlan);
            closePlan1.addEventListener('click', closePlan);
            closePlan2.addEventListener('click', closePlan);
            planOverlay.addEventListener('click', closePlan);
        }

        planCards.forEach(card => {
            card.addEventListener('click', function () {
                const val = this.dataset.plan;
                planType.value = val;

                planCards.forEach(c => {
                    c.classList.remove('border-brand', 'bg-brand/10', 'ring-1', 'ring-brand');
                    c.classList.add('border-surface-border', 'bg-surface');
                });

                this.classList.remove('border-surface-border', 'bg-surface');
                this.classList.add('border-brand', 'bg-brand/10', 'ring-1', 'ring-brand');
            });
        });

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                closePlan();
                if (deleteModal) {
                    deleteModal.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            }
        });
    });
</script>
@endsection
