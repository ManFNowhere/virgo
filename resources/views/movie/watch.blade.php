<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $movie->title }} — Virgo</title>
    <link rel="icon" href="{{ asset('/img/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { margin: 0; background: #000; overflow: hidden; }
        video::-webkit-media-controls { display: none !important; }
    </style>
</head>
<body class="bg-black">

{{-- ── Full-screen player ───────────────────────────────────────── --}}
<div id="player-wrap" class="relative w-screen h-screen flex items-center justify-center bg-black cursor-none">

    <video id="main-video"
           class="w-full h-full object-contain"
           src="{{ route('stream', ['type' => 'movie', 'filename' => basename($movie->movie)]) }}"
           preload="metadata">
        Your browser does not support HTML5 video.
    </video>

    {{-- Top overlay: back + title --}}
    <div id="overlay-top"
         class="player-overlay absolute top-0 left-0 right-0 px-6 py-5 flex items-center gap-4
                bg-gradient-to-b from-black/80 to-transparent transition-opacity duration-500">
        <button id="btn-back-nav" data-href="{{ url()->previous() !== url()->current() ? url()->previous() : url('/movie/'.$movie->slug) }}"
                class="flex items-center justify-center w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 text-white transition flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        <div>
            <p class="text-white/50 text-xs uppercase tracking-widest">Now Playing</p>
            <p class="text-white font-semibold text-sm sm:text-base">{{ $movie->title }}</p>
        </div>
    </div>

    {{-- Bottom overlay: custom controls --}}
    <div id="overlay-bottom"
         class="player-overlay absolute bottom-0 left-0 right-0 px-6 pb-6 pt-16
                bg-gradient-to-t from-black/90 to-transparent transition-opacity duration-500">

        {{-- Progress bar --}}
        <div class="flex items-center gap-3 mb-4">
            <span id="time-current" class="text-white/70 text-xs font-mono w-10 text-right flex-shrink-0">0:00</span>
            <div id="progress-container" class="relative flex-1 h-1 bg-white/20 rounded-full cursor-pointer group">
                <div id="progress-bar" class="h-full bg-white rounded-full relative transition-all" style="width:0%">
                    <div class="absolute right-0 top-1/2 -translate-y-1/2 w-3 h-3 bg-white rounded-full scale-0 group-hover:scale-100 transition-transform -translate-x-1/2"></div>
                </div>
            </div>
            <span id="time-total" class="text-white/70 text-xs font-mono w-10 flex-shrink-0">0:00</span>
        </div>

        {{-- Control buttons --}}
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                {{-- Play/Pause --}}
                <button id="btn-play" class="text-white hover:text-white/80 transition" aria-label="Play/Pause">
                    <svg id="icon-play" class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                    </svg>
                    <svg id="icon-pause" class="w-8 h-8 hidden" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </button>

                {{-- Skip back 10s --}}
                <button id="btn-back" class="text-white/70 hover:text-white transition" aria-label="Rewind 10s">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0019 16V8a1 1 0 00-1.6-.8l-5.333 4zM4.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0011 16V8a1 1 0 00-1.6-.8l-5.334 4z"/>
                    </svg>
                </button>

                {{-- Skip forward 10s --}}
                <button id="btn-fwd" class="text-white/70 hover:text-white transition" aria-label="Forward 10s">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.933 12.8a1 1 0 000-1.6L6.6 7.2A1 1 0 005 8v8a1 1 0 001.6.8l5.333-4zM19.933 12.8a1 1 0 000-1.6l-5.333-4A1 1 0 0013 8v8a1 1 0 001.6.8l5.333-4z"/>
                    </svg>
                </button>

                {{-- Volume --}}
                <div class="flex items-center gap-2 group/vol">
                    <button id="btn-mute" class="text-white/70 hover:text-white transition" aria-label="Mute">
                        <svg id="icon-vol" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072M12 6v12m0 0l-3.5-3.5M12 18l3.5-3.5M6 10H4a1 1 0 00-1 1v2a1 1 0 001 1h2l4 4V6L6 10z"/>
                        </svg>
                        <svg id="icon-mute" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"/>
                        </svg>
                    </button>
                    <input id="volume-slider" type="range" min="0" max="1" step="0.05" value="1"
                           class="w-0 group-hover/vol:w-20 transition-all duration-200 accent-white cursor-pointer h-1 opacity-0 group-hover/vol:opacity-100">
                </div>
            </div>

            <div class="flex items-center gap-4">
                {{-- Fullscreen --}}
                <button id="btn-fullscreen" class="text-white/70 hover:text-white transition" aria-label="Fullscreen">
                    <svg id="icon-expand" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                    </svg>
                    <svg id="icon-shrink" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9V4.5M9 9H4.5M9 9L3.75 3.75M9 15v4.5M9 15H4.5M9 15l-5.25 5.25M15 9h4.5M15 9V4.5M15 9l5.25-5.25M15 15h4.5M15 15v4.5m0-4.5l5.25 5.25"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

</div>

<script>
    const video       = document.getElementById('main-video');
    const wrap        = document.getElementById('player-wrap');
    const overlays    = document.querySelectorAll('.player-overlay');
    const btnPlay     = document.getElementById('btn-play');
    const iconPlay    = document.getElementById('icon-play');
    const iconPause   = document.getElementById('icon-pause');
    const btnBack     = document.getElementById('btn-back');
    const btnFwd      = document.getElementById('btn-fwd');
    const btnMute     = document.getElementById('btn-mute');
    const iconVol     = document.getElementById('icon-vol');
    const iconMuteI   = document.getElementById('icon-mute');
    const volSlider   = document.getElementById('volume-slider');
    const btnFs       = document.getElementById('btn-fullscreen');
    const iconExpand  = document.getElementById('icon-expand');
    const iconShrink  = document.getElementById('icon-shrink');
    const progressBar = document.getElementById('progress-bar');
    const progressCon = document.getElementById('progress-container');
    const timeCurrent = document.getElementById('time-current');
    const timeTotal   = document.getElementById('time-total');

    // ── Back navigation: stop video immediately before leaving ────
    document.getElementById('btn-back-nav').addEventListener('click', function () {
        const dest = this.dataset.href;
        video.pause();
        video.src = '';
        video.load();
        window.location.href = dest;
    });

    // ── Overlay auto-hide ──────────────────────────────────────────
    let hideTimer;
    function showOverlays() {
        overlays.forEach(o => o.classList.remove('opacity-0'));
        wrap.classList.remove('cursor-none');
        wrap.classList.add('cursor-auto');
        clearTimeout(hideTimer);
        if (!video.paused) {
            hideTimer = setTimeout(() => {
                overlays.forEach(o => o.classList.add('opacity-0'));
                wrap.classList.add('cursor-none');
                wrap.classList.remove('cursor-auto');
            }, 3000);
        }
    }
    wrap.addEventListener('mousemove', showOverlays);
    wrap.addEventListener('click', showOverlays);
    wrap.addEventListener('touchstart', showOverlays, { passive: true });

    // ── Play / Pause ───────────────────────────────────────────────
    function syncPlayState() {
        iconPlay.classList.toggle('hidden', !video.paused);
        iconPause.classList.toggle('hidden', video.paused);
    }
    btnPlay.addEventListener('click', () => { video.paused ? video.play() : video.pause(); });
    wrap.addEventListener('dblclick', () => { video.paused ? video.play() : video.pause(); });
    video.addEventListener('play', syncPlayState);
    video.addEventListener('pause', syncPlayState);
    video.play().catch(() => {});

    // ── Skip ───────────────────────────────────────────────────────
    btnBack.addEventListener('click', () => { video.currentTime = Math.max(0, video.currentTime - 10); });
    btnFwd.addEventListener('click',  () => { video.currentTime = Math.min(video.duration || Infinity, video.currentTime + 10); });

    // ── Volume ─────────────────────────────────────────────────────
    btnMute.addEventListener('click', () => {
        video.muted = !video.muted;
        iconVol.classList.toggle('hidden', video.muted);
        iconMuteI.classList.toggle('hidden', !video.muted);
        volSlider.value = video.muted ? 0 : video.volume;
    });
    volSlider.addEventListener('input', () => {
        video.volume = volSlider.value;
        video.muted  = video.volume === 0;
        iconVol.classList.toggle('hidden', video.muted);
        iconMuteI.classList.toggle('hidden', !video.muted);
    });

    // ── Progress ───────────────────────────────────────────────────
    function fmt(s) {
        s = Math.floor(s || 0);
        const m = Math.floor(s / 60), sec = s % 60;
        return m + ':' + String(sec).padStart(2, '0');
    }
    video.addEventListener('loadedmetadata', () => { timeTotal.textContent = fmt(video.duration); });
    video.addEventListener('timeupdate', () => {
        const pct = video.duration ? (video.currentTime / video.duration) * 100 : 0;
        progressBar.style.width = pct + '%';
        timeCurrent.textContent = fmt(video.currentTime);
    });
    progressCon.addEventListener('click', e => {
        const rect = progressCon.getBoundingClientRect();
        video.currentTime = ((e.clientX - rect.left) / rect.width) * (video.duration || 0);
    });

    // ── Fullscreen ─────────────────────────────────────────────────
    btnFs.addEventListener('click', () => {
        if (!document.fullscreenElement) {
            wrap.requestFullscreen?.() || wrap.webkitRequestFullscreen?.();
        } else {
            document.exitFullscreen?.() || document.webkitExitFullscreen?.();
        }
    });
    document.addEventListener('fullscreenchange', () => {
        const isFs = !!document.fullscreenElement;
        iconExpand.classList.toggle('hidden', isFs);
        iconShrink.classList.toggle('hidden', !isFs);
    });

    // ── Keyboard shortcuts ─────────────────────────────────────────
    document.addEventListener('keydown', e => {
        if (['Space','ArrowLeft','ArrowRight','KeyM','KeyF'].includes(e.code)) {
            e.preventDefault();
            showOverlays();
            if (e.code === 'Space')       { video.paused ? video.play() : video.pause(); }
            if (e.code === 'ArrowLeft')   { video.currentTime -= 10; }
            if (e.code === 'ArrowRight')  { video.currentTime += 10; }
            if (e.code === 'KeyM')        { btnMute.click(); }
            if (e.code === 'KeyF')        { btnFs.click(); }
        }
    });
</script>
</body>
</html>
