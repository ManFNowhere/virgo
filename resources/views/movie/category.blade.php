@extends('layouts.app')

@section('container')
<div class="min-h-screen bg-surface pt-24 pb-16">

    {{-- ── Header ──────────────────────────────────────────────── --}}
    <div class="px-6 sm:px-12 mb-6">
        <h1 class="text-content-primary text-2xl font-bold">Browse by Genre</h1>
        <p class="text-content-muted text-sm mt-1">{{ count($genre) }} genres available</p>
    </div>

    {{-- ── Genre pills (quick-jump) ───────────────────────────── --}}
    <div class="px-6 sm:px-12 mb-8">
        <div class="flex gap-2 overflow-x-auto pb-2 [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">
            @foreach ($genre as $g)
                @if ($g)
                <a href="#genre-{{ $g->id_genre }}"
                   class="flex-shrink-0 text-xs font-medium px-4 py-2 rounded-full border border-surface-border bg-surface-raised text-content-secondary hover:border-brand/60 hover:text-white transition">
                    {{ $g->genre }}
                </a>
                @endif
            @endforeach
        </div>
    </div>

    {{-- ── Genre sections ─────────────────────────────────────── --}}
    <div class="space-y-10">
        @foreach ($genre as $g)
            @if (!$g) @continue @endif

            @php
                $genreMovies = $movies->filter(function($movie) use ($g) {
                    return in_array($g->id_genre, explode(',', $movie['genre']));
                });
            @endphp

            @if ($genreMovies->isEmpty()) @continue @endif

            <section id="genre-{{ $g->id_genre }}" class="px-6 sm:px-12 scroll-mt-24">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <h2 class="text-content-primary text-lg font-bold">{{ $g->genre }}</h2>
                        <span class="text-xs text-content-muted bg-surface-raised border border-surface-border px-2 py-0.5 rounded-full">
                            {{ $genreMovies->count() }}
                        </span>
                    </div>
                </div>
                <div class="flex gap-3 overflow-x-auto pb-2 [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">
                    @foreach ($genreMovies as $movie)
                        @include('components.card')
                    @endforeach
                </div>
            </section>
        @endforeach
    </div>

</div>
@endsection
