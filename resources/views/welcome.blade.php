@extends('layouts.app')

@section('container')

{{-- ── Hero ──────────────────────────────────────────────────────── --}}
<div class="relative w-full h-[82vh] min-h-[500px] overflow-hidden">

    <video id="banner" class="absolute inset-0 w-full h-full object-cover" autoplay muted playsinline>
        <source src="{{ url($data[0]->trailer) }}" type="video/mp4">
    </video>

    {{-- gradient: bottom fade to bg-surface, left fade for text legibility --}}
    <div class="absolute inset-0 bg-gradient-to-t from-surface via-surface/50 to-transparent"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-surface/80 via-surface/20 to-transparent"></div>

    {{-- movie info --}}
    <div class="absolute bottom-0 left-0 px-6 sm:px-12 pb-14 max-w-xl">
        <p class="text-content-muted text-xs font-semibold uppercase tracking-widest mb-2">Featured</p>
        <h1 class="text-content-primary text-3xl sm:text-5xl font-bold leading-tight mb-3">{{ $data[0]->title }}</h1>
        <p class="text-content-secondary text-sm sm:text-base line-clamp-3 mb-6 hidden sm:block">{{ $data[0]->overview }}</p>
        <div class="flex items-center gap-3 flex-wrap">
            <a href="{{ url('/watch/'.$data[0]->slug) }}"
               class="flex items-center gap-2 bg-white text-surface font-semibold text-sm px-6 py-3 rounded-xl hover:bg-white/90 transition">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                </svg>
                Watch now
            </a>
            <a href="{{ url('/movie/'.$data[0]->slug) }}"
               class="flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 text-content-primary font-semibold text-sm px-6 py-3 rounded-xl hover:bg-white/20 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                More info
            </a>
        </div>
    </div>
</div>

{{-- ── Movie Rows ────────────────────────────────────────────────── --}}
<div class="bg-surface pb-16 space-y-10 -mt-1">

    {{-- New Releases --}}
    <section class="px-6 sm:px-12">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-content-primary text-lg sm:text-xl font-bold">New Releases</h2>
            <a href="{{ url('/show/new-release') }}"
               class="flex items-center gap-1 text-content-muted hover:text-content-primary text-sm transition">
                See all
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
        <div class="flex gap-3 overflow-x-auto pb-2 [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">
            @foreach ($data->skip(1) as $movie)
                @include('components.card')
            @endforeach
        </div>
    </section>

    {{-- Top Free Movies --}}
    <section id="free-movies" class="px-6 sm:px-12">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-content-primary text-lg sm:text-xl font-bold">Top Free Movies</h2>
            <a href="{{ url('/show/free') }}"
               class="flex items-center gap-1 text-content-muted hover:text-content-primary text-sm transition">
                See all
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
        <div class="flex gap-3 overflow-x-auto pb-2 [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">
            @foreach ($free as $movie)
                @include('components.card')
            @endforeach
        </div>
    </section>

    {{-- Top Movies --}}
    <section id="top-movies" class="px-6 sm:px-12">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-content-primary text-lg sm:text-xl font-bold">Top Movies</h2>
            <a href="{{ url('/show/watched') }}"
               class="flex items-center gap-1 text-content-muted hover:text-content-primary text-sm transition">
                See all
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
        <div class="flex gap-3 overflow-x-auto pb-2 [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">
            @foreach ($watch as $movie)
                @include('components.card')
            @endforeach
        </div>
    </section>

</div>

<script>
    const video = document.getElementById('banner');
    const start = 50, end = 100;

    video.addEventListener('loadeddata', () => {
        video.currentTime = start;
        video.play().catch(() => {});
    });

    video.addEventListener('timeupdate', () => {
        if (video.currentTime >= end) video.currentTime = start;
    });
</script>

@endsection
