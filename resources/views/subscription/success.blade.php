@extends('layouts.app')

@section('container')
<div class="p-10">
    <div class="bg-gray-900 min-h-96 text-center p-10 rounded ">
       <div class="bg-gray-800 p-10 flex flex-col items-center rounded mx-auto w-fit">
            <img src="{{ asset('storage/success.png') }}" class="w-60" alt="Virgo Logo" />
            <h1 class="text-white text-4xl font-bold">Thank you for subscribing!</h1>
            <p class="text-white">You have successfully subcribe to our services.</p>
            <a href="{{ url('/dashboard') }}" class="text-white text-sm mx-4 sm:mx-20 bg-purple-500 p-2 rounded hover:bg-purple-400 my-4">Back to Dashboard</a>
            <a href="{{ url('/') }}" class="flex items-center rtl:space-x-reverse my-4">
                <img src="{{ asset('storage/logo.png') }}" class="h-10" alt="Virgo Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap">Virgo</span>
            </a>
       </div>
    </div>
</div>


@endsection