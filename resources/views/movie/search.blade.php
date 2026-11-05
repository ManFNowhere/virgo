@extends('layouts.app')

@section('container')
<div class="min-h-screen bg-surface pt-24 pb-12 px-4 sm:px-8">
    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <div class="mb-8">
            <p class="text-content-muted text-sm mb-1">Search results for</p>
            <h1 class="text-content-primary text-2xl font-bold">"{{ $search }}"</h1>
            @if (count($movies) > 0)
                <p class="text-content-muted text-sm mt-1">{{ count($movies) }} {{ count($movies) === 1 ? 'movie' : 'movies' }} found</p>
            @endif
        </div>

        @if (count($movies) > 0)
            <div class="flex flex-wrap gap-3 sm:gap-4">
                @foreach ($movies as $movie)
                    @include('components.card')
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-28 text-center">
                <svg class="w-14 h-14 text-content-muted mb-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>
                <p class="text-content-primary font-semibold text-lg mb-1">No results found</p>
                <p class="text-content-muted text-sm">Try a different title or check your spelling.</p>
                <a href="{{ url('/') }}"
                   class="mt-6 bg-brand hover:bg-brand-dark text-white text-sm font-medium px-5 py-2.5 rounded-xl transition">
                    Back to Home
                </a>
            </div>
        @endif

    </div>
</div>
@endsection
