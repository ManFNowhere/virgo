@extends('layouts.app')

@section('container')

<div class="fixed inset-0 flex items-center justify-center bg-surface px-6 overflow-y-auto">
    <div class="w-full max-w-md py-12">

        <!-- Logo -->
        <div class="flex justify-center mb-8">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <img src="{{ asset('/img/logo.png') }}" class="h-9" alt="Virgo Logo">
                <span class="text-white text-xl font-bold tracking-widest uppercase">Virgo</span>
            </a>
        </div>

        <h1 class="text-content-primary text-3xl font-bold mb-2">Forgot password?</h1>
        <p class="text-content-secondary text-sm mb-8">Enter your email and we'll send you a reset link.</p>

        @if (session('status'))
        <div class="flex items-center gap-3 bg-green-900/40 border border-green-700 text-green-400 text-sm rounded-xl px-4 py-3 mb-6">
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span>{{ session('status') }}</span>
        </div>
        @endif

        <form action="{{ route('password.email') }}" method="post" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-content-secondary text-xs font-medium mb-1.5">Email address</label>
                <input type="email" name="email" id="email"
                       value="{{ old('email') }}" placeholder="john@example.com"
                       class="w-full bg-surface-card border border-surface-border text-content-primary text-sm rounded-xl px-4 py-3 outline-none focus:border-brand focus:ring-1 focus:ring-brand placeholder-content-muted transition" required>
                @error('email')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="w-full bg-brand hover:bg-brand-dark text-white font-semibold text-sm py-3.5 rounded-xl transition">
                Send reset link
            </button>

            <p class="text-center text-content-secondary text-sm pt-2">
                Remember your password?
                <a href="{{ route('login') }}" class="text-brand hover:text-brand-light font-medium transition">Back to sign in</a>
            </p>

        </form>
    </div>
</div>

@endsection
