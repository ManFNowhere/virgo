<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-900 ">
   
    <div class="mb-4 text-sm text-gray-600 flex flex-col bg-gray-700 p-10 m-4 md:m-40 lg:m-80 rounded ">
    @include('components.logo')
            <h5>Thanks for signing up! Before getting started, please verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.</h5>
            <div class="mt-4 flex items-center justify-between">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button class="bg-blue-700 p-2 rounded text-white hover:bg-blue-600" type="submit">Resend email</button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="hover:bg-gray-500 p-2 rounded" type="submit">logout</button>
                </form>
            </div>
    </div>
</body>
