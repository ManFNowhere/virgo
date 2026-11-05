@extends('layouts.app')

@section('container')

{{-- ── Trailer Modal (full-screen style) ──────────────────────── --}}
<div id="trailer-modal" class="hidden fixed inset-0 z-50 bg-black flex flex-col">

    {{-- Top bar --}}
    <div class="flex items-center justify-between px-6 py-4 bg-gradient-to-b from-black/80 to-transparent flex-shrink-0">
        <div>
            <p class="text-white/50 text-xs uppercase tracking-widest">Trailer</p>
            <p class="text-white font-semibold text-sm">{{ $data['title'] }}</p>
        </div>
        <button id="exit-trailer"
                class="flex items-center gap-2 text-white/70 hover:text-white text-sm transition px-3 py-1.5 rounded-xl hover:bg-white/10">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Close
        </button>
    </div>

    {{-- Video --}}
    <div class="flex-1 flex items-center justify-center px-4 pb-8">
        <video id="video-trailer"
               class="w-full max-w-5xl max-h-[80vh] rounded-xl shadow-2xl bg-black"
               controls>
            <source src="{{ route('stream', ['type' => 'trailer', 'filename' => basename($data['trailer'])]) }}" type="video/mp4">
        </video>
    </div>
</div>

{{-- ── Page body ───────────────────────────────────────────────── --}}
<div class="min-h-screen bg-surface pt-24 pb-16 px-4 sm:px-8">
    <div class="max-w-5xl mx-auto">

        {{-- Back --}}
        <a href="javascript:history.back()"
           class="inline-flex items-center gap-2 text-content-muted hover:text-content-primary text-sm transition mb-8">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back
        </a>

        {{-- ── Main card ──────────────────────────────────────────────── --}}
        <div class="bg-surface-card border border-surface-border rounded-2xl overflow-hidden">

            {{-- Blurred poster backdrop --}}
            @if ($data['cover'])
            <div class="relative h-48 sm:h-64 overflow-hidden">
                <img src="https://image.tmdb.org/t/p/w1280{{ $data['cover'] }}"
                     class="w-full h-full object-cover scale-110 blur-sm opacity-30" alt="">
                <div class="absolute inset-0 bg-gradient-to-b from-transparent to-surface-card"></div>
            </div>
            @endif

            {{-- Content row --}}
            <div class="flex flex-col sm:flex-row gap-6 px-6 pb-8 {{ $data['cover'] ? '-mt-24 sm:-mt-32 relative' : 'pt-6' }}">

                {{-- Poster --}}
                @if ($data['cover'])
                <div class="flex-shrink-0 w-36 sm:w-48">
                    <img src="https://image.tmdb.org/t/p/w300{{ $data['cover'] }}"
                         alt="{{ $data['title'] }}"
                         class="w-full rounded-xl border border-surface-border shadow-2xl">
                </div>
                @endif

                {{-- Details --}}
                <div class="flex-1 min-w-0 {{ $data['cover'] ? 'pt-0 sm:pt-28' : '' }}">

                    {{-- Title + badges --}}
                    <h1 class="text-content-primary text-2xl sm:text-3xl font-bold leading-tight mb-3">{{ $data['title'] }}</h1>

                    <div class="flex flex-wrap gap-2 mb-4">
                        {{-- Release year --}}
                        <span class="text-xs bg-surface-raised border border-surface-border text-content-secondary px-2.5 py-1 rounded-lg">
                            {{ substr($data['release_date'], 0, 4) }}
                        </span>
                        {{-- Rating --}}
                        @if ($data['vote'] > 0)
                        <span class="flex items-center gap-1 text-xs bg-surface-raised border border-surface-border text-content-secondary px-2.5 py-1 rounded-lg">
                            <svg class="w-3 h-3 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            {{ number_format($data['vote'], 1) }}
                        </span>
                        @endif
                        {{-- Type --}}
                        <span class="text-xs px-2.5 py-1 rounded-lg {{ $data['type'] == 1 ? 'bg-green-900/50 text-green-400 border border-green-800/60' : 'bg-brand/20 text-brand-light border border-brand/30' }}">
                            {{ $data['type'] == 1 ? 'Free' : 'Premium' }}
                        </span>
                        {{-- Genres --}}
                        @foreach ($genre as $g)
                        <span class="text-xs bg-surface-raised border border-surface-border text-content-muted px-2.5 py-1 rounded-lg">{{ $g }}</span>
                        @endforeach
                    </div>

                    {{-- Overview --}}
                    <p class="text-content-secondary text-sm leading-relaxed mb-6">{{ $data['overview'] }}</p>

                    {{-- Action buttons --}}
                    <div class="flex gap-3 flex-wrap">
                        <a href="{{ url('/watch/'.$data['slug']) }}"
                           class="flex items-center gap-2 bg-white text-surface font-semibold text-sm px-5 py-2.5 rounded-xl hover:bg-white/90 transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                            </svg>
                            Watch
                        </a>
                        <button id="open-trailer"
                                class="flex items-center gap-2 bg-surface-raised border border-surface-border text-content-primary font-semibold text-sm px-5 py-2.5 rounded-xl hover:bg-surface-border transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Trailer
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Cast ───────────────────────────────────────────────────── --}}
        @if (!empty($cast))
        <div class="mt-8">
            <h2 class="text-content-primary text-lg font-bold mb-4">Cast</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3">
                @foreach ($cast as $c)
                <div class="bg-surface-card border border-surface-border rounded-xl overflow-hidden text-center">
                    @if ($c['profile_path'])
                    <img src="https://image.tmdb.org/t/p/w185{{ $c['profile_path'] }}"
                         alt="{{ $c['name'] }}"
                         class="w-full aspect-[2/3] object-cover object-top">
                    @else
                    <div class="w-full aspect-[2/3] bg-surface-raised flex items-center justify-center">
                        <svg class="w-8 h-8 text-content-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    @endif
                    <div class="p-2">
                        <p class="text-content-primary text-xs font-semibold leading-tight truncate">{{ $c['name'] }}</p>
                        <p class="text-content-muted text-xs truncate mt-0.5">{{ $c['character'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ── Key Crew ────────────────────────────────────────────────── --}}
        @php
            $keyCrew = collect($crew)->whereIn('job', ['Director','Screenplay','Writer','Story','Producer'])->take(8);
        @endphp
        @if ($keyCrew->isNotEmpty())
        <div class="mt-8">
            <h2 class="text-content-primary text-lg font-bold mb-4">Crew</h2>
            <div class="bg-surface-card border border-surface-border rounded-2xl divide-y divide-surface-border">
                @foreach ($keyCrew as $c)
                <div class="flex items-center justify-between px-5 py-3">
                    <span class="text-content-primary text-sm font-medium">{{ $c['name'] }}</span>
                    <span class="text-content-muted text-xs bg-surface-raised px-2.5 py-1 rounded-lg">{{ $c['job'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal    = document.getElementById('trailer-modal');
        const video    = document.getElementById('video-trailer');
        const openBtn  = document.getElementById('open-trailer');
        const closeBtn = document.getElementById('exit-trailer');

        openBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            video.play().catch(() => {});
        });

        function closeTrailer() {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
            video.pause();
            video.currentTime = 0;
        }

        closeBtn.addEventListener('click', closeTrailer);
        modal.addEventListener('click', e => { if (e.target === modal) closeTrailer(); });
        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeTrailer(); });
    });
</script>

@endsection
