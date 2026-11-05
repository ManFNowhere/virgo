@extends('layouts.app')

@section('container')
<div class="min-h-screen bg-surface pt-24 pb-12 px-4 sm:px-8">
    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ url('/') }}" class="text-content-muted hover:text-content-primary transition p-2 rounded-xl hover:bg-surface-raised">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="text-content-primary text-2xl font-bold">{{ $label }}</h1>
                <p class="text-content-muted text-sm mt-0.5">{{ $data->count() }} movies</p>
            </div>
        </div>

        @if ($data->isEmpty())
        <div class="text-center py-24">
            <svg class="w-12 h-12 text-content-muted mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.069A1 1 0 0121 8.87v6.26a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
            </svg>
            <p class="text-content-muted">No movies found.</p>
        </div>
        @else
        <div class="flex flex-wrap gap-3 sm:gap-4">
            @foreach ($data as $movie)
                @include('components.card')
            @endforeach
        </div>
        @endif

    </div>
</div>
@endsection
