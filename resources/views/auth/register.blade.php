@extends('layouts.app')

@section('container')

<!-- Term Modal -->
<div id="term-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" id="term-overlay"></div>
    <div class="relative bg-surface-card rounded-2xl w-full max-w-2xl max-h-[80vh] flex flex-col shadow-2xl">
        <div class="flex items-center justify-between px-6 py-4 border-b border-surface-border">
            <h2 class="text-content-primary font-semibold text-lg">Terms & Conditions</h2>
            <button id="close-term" class="text-content-muted hover:text-content-primary transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="overflow-y-auto px-6 py-4 text-content-secondary text-sm leading-relaxed space-y-3">
            @include('modals.term-content')
        </div>
        <div class="px-6 py-4 border-t border-surface-border flex justify-end">
            <button id="close-term-btn" class="bg-brand hover:bg-brand-dark text-white text-sm font-medium px-5 py-2 rounded-lg transition">
                Close
            </button>
        </div>
    </div>
</div>

<!-- Page -->
<div class="fixed inset-0 flex overflow-hidden">

    <!-- Left: Image Panel (hidden on mobile) -->
    <div class="hidden lg:flex lg:w-1/2 relative">
        <img src="https://picsum.photos/800/1000?grayscale" alt="Register visual"
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-black/30 to-transparent"></div>
        <div class="absolute bottom-12 left-10">
            <a href="{{ url('/') }}" class="flex items-center gap-3 mb-6">
                <img src="{{ asset('/img/logo.png') }}" class="h-10" alt="Virgo Logo">
                <span class="text-white text-2xl font-bold tracking-widest uppercase">Virgo</span>
            </a>
            <p class="text-white/80 text-lg max-w-xs leading-relaxed">
                Unlimited movies, TV shows, and more. Watch anywhere. Cancel anytime.
            </p>
        </div>
    </div>

    <!-- Right: Form Panel -->
    <div class="w-full lg:w-1/2 flex items-center justify-center bg-surface px-6 py-12 overflow-y-auto">
        <div class="w-full max-w-md">

            <!-- Mobile logo -->
            <div class="flex justify-center mb-8 lg:hidden">
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <img src="{{ asset('/img/logo.png') }}" class="h-9" alt="Virgo Logo">
                    <span class="text-white text-xl font-bold tracking-widest uppercase">Virgo</span>
                </a>
            </div>

            <h1 class="text-content-primary text-3xl font-bold mb-2">Create account</h1>
            <p class="text-content-secondary text-sm mb-8">Start watching today. No commitments.</p>

            <form action="{{ url('/register') }}" method="post" class="space-y-5">
                @csrf

                <!-- Name row -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-content-secondary text-xs font-medium mb-1.5">First name</label>
                        <input type="text" name="first_name" id="first_name"
                               value="{{ old('first_name') }}" placeholder="John"
                               class="w-full bg-surface-card border border-surface-border text-content-primary text-sm rounded-xl px-4 py-3 outline-none focus:border-brand focus:ring-1 focus:ring-brand placeholder-content-muted transition" required>
                        @error('first_name')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="last_name" class="block text-content-secondary text-xs font-medium mb-1.5">Last name</label>
                        <input type="text" name="last_name" id="last_name"
                               value="{{ old('last_name') }}" placeholder="Doe"
                               class="w-full bg-surface-card border border-surface-border text-content-primary text-sm rounded-xl px-4 py-3 outline-none focus:border-brand focus:ring-1 focus:ring-brand placeholder-content-muted transition" required>
                        @error('last_name')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-content-secondary text-xs font-medium mb-1.5">Email address</label>
                    <input type="email" name="email" id="email"
                           value="{{ old('email') }}" placeholder="john@example.com"
                           class="w-full bg-surface-card border border-surface-border text-content-primary text-sm rounded-xl px-4 py-3 outline-none focus:border-brand focus:ring-1 focus:ring-brand placeholder-content-muted transition" required>
                    @error('email')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-content-secondary text-xs font-medium mb-1.5">Password</label>
                    <input type="password" name="password" id="password"
                           placeholder="Min. 8 characters"
                           class="w-full bg-surface-card border border-surface-border text-content-primary text-sm rounded-xl px-4 py-3 outline-none focus:border-brand focus:ring-1 focus:ring-brand placeholder-content-muted transition" required>
                    @error('password')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-content-secondary text-xs font-medium mb-1.5">Confirm password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           placeholder="Repeat your password"
                           class="w-full bg-surface-card border border-surface-border text-content-primary text-sm rounded-xl px-4 py-3 outline-none focus:border-brand focus:ring-1 focus:ring-brand placeholder-content-muted transition" required>
                    @error('password_confirmation')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Checkboxes -->
                <div class="space-y-3 pt-1">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input id="term-checkbox" name="term" type="checkbox"
                               class="mt-0.5 w-4 h-4 text-brand rounded accent-brand focus:text-brand focus:border-brand focus:ring-2 focus:ring-brand
                               flex-shrink-0" required>
                        <span class="text-content-secondary text-sm">
                            I have read and agree to the
                            <button type="button" id="term-button" class="text-brand hover:text-brand-light underline underline-offset-2 transition">Terms & Conditions</button>
                        </span>
                    </label>

                    <label class="flex items-start gap-3 cursor-pointer">
                        <input id="sub-checkbox" name="sub" type="checkbox" value="1"
                                 class="mt-0.5 w-4 h-4 text-brand rounded accent-brand focus:text-brand focus:border-brand focus:ring-2 focus:ring-brand
                               flex-shrink-0">
                        <span class="text-content-secondary text-sm">
                            Subscribe to our newsletter for new movie updates.
                        </span>
                    </label>
                </div>

                <!-- Submit -->
                <button type="submit"
                        class="w-full bg-brand hover:bg-brand-dark text-white font-semibold text-sm py-3.5 rounded-xl transition mt-2">
                    Create account
                </button>

                <!-- Login link -->
                <p class="text-center text-content-secondary text-sm pt-2">
                    Already have an account?
                    <a href="{{ url('/login') }}" class="text-brand hover:text-brand-light font-medium transition">Sign in</a>
                </p>

            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const termButton = document.getElementById('term-button');
        const termModal  = document.getElementById('term-modal');
        const closeBtn   = document.getElementById('close-term');
        const closeBtnFooter = document.getElementById('close-term-btn');
        const overlay    = document.getElementById('term-overlay');

        function openTerm()  { termModal.classList.remove('hidden'); document.body.style.overflow = 'hidden'; }
        function closeTerm() { termModal.classList.add('hidden');    document.body.style.overflow = ''; }

        termButton.addEventListener('click', openTerm);
        closeBtn.addEventListener('click', closeTerm);
        closeBtnFooter.addEventListener('click', closeTerm);
        overlay.addEventListener('click', closeTerm);
        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeTerm(); });
    });
</script>

@endsection
