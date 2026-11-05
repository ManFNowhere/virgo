@extends('layouts.app')

@section('container')
<div id="login-body" class="flex mx-auto text-center justify-center my-20 lg:m-0 lg:p-40">
    <form action="{{ route('password.store') }}" method="post" class="w-5/6 md:w-2/3 flex flex-col justify-center border border-gray-700 rounded bg-gray-800 mx-4 p-10">
        @csrf
        @include('components.logo')
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div class="mb-5 text-left">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Your email</label>
            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5" value="{{ old('email', $request->email) }}" required />
            @error('email')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-5 text-left">
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">New password</label>
            <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5" required />
            @error('password')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-5 text-left">
            <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">Confirm new password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5" required />
            @error('password_confirmation')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="text-white text-xl">Reset password</button>
    </form>
</div>
@endsection
