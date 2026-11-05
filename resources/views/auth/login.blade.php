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

        <h1 class="text-content-primary text-3xl font-bold mb-2">Welcome back</h1>
        <p class="text-content-secondary text-sm mb-6">Sign in to continue watching.</p>

        <!-- Demo hint -->
        <div class="bg-surface-card border border-surface-border rounded-xl px-4 py-3 mb-6 space-y-1.5">
            <p class="text-content-muted text-xs font-medium uppercase tracking-wider mb-2">Demo accounts</p>
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs bg-brand/20 text-brand px-2 py-0.5 rounded font-medium">Admin</span>
                    <span class="text-content-secondary text-xs ml-2">admin@demo.com</span>
                </div>
                <span class="text-content-muted text-xs">password</span>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs bg-surface-raised text-content-secondary px-2 py-0.5 rounded font-medium">Viewer</span>
                    <span class="text-content-secondary text-xs ml-2">viewer@demo.com</span>
                </div>
                <span class="text-content-muted text-xs">password</span>
            </div>
        </div>

        @if (session()->has('login-success'))
        <div id="alert" class="flex items-center gap-3 bg-green-900/40 border border-green-700 text-green-400 text-sm rounded-xl px-4 py-3 mb-6">
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span>{{ session('login-success') }}</span>
            <button type="button" id="close-alert" class="ml-auto text-green-400 hover:text-green-300 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 14 14">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
        @endif

        <form action="{{ url('/login') }}" method="post" class="space-y-5">
            @csrf

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
                <div class="flex items-center justify-between mb-1.5">
                    <label for="password" class="text-content-secondary text-xs font-medium">Password</label>
                    <a href="{{ route('password.request') }}" class="text-brand hover:text-brand-light text-xs transition">Forgot password?</a>
                </div>
                <input type="password" name="password" id="password"
                       placeholder="Your password"
                       class="w-full bg-surface-card border border-surface-border text-content-primary text-sm rounded-xl px-4 py-3 outline-none focus:border-brand focus:ring-1 focus:ring-brand placeholder-content-muted transition" required>
                @error('password')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <button type="submit"
                    class="w-full bg-brand hover:bg-brand-dark text-white font-semibold text-sm py-3.5 rounded-xl transition mt-2">
                Sign in
            </button>

            <!-- Register link -->
            <p class="text-center text-content-secondary text-sm pt-2">
                Don't have an account?
                <a href="{{ url('/register') }}" class="text-brand hover:text-brand-light font-medium transition">Create one</a>
            </p>

        </form>
    </div>
</div>

@if (session()->has('login-success'))
<script>
    document.getElementById('close-alert')?.addEventListener('click', function () {
        document.getElementById('alert').remove();
    });
</script>
@endif

@endsection
