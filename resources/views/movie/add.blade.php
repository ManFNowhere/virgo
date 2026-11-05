@extends('layouts.app')

@section('container')
<div class="min-h-screen bg-surface pt-20 pb-10 px-4 sm:px-8">
    <div class="max-w-2xl mx-auto space-y-6">

        <!-- Header -->
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" class="text-content-muted hover:text-content-primary transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="text-content-primary text-2xl font-bold">Add Movie</h1>
        </div>

        <!-- Step 1: Search -->
        <div class="bg-surface-card border border-surface-border rounded-2xl p-6">
            <h2 class="text-content-primary font-semibold mb-1">Step 1 — Search from TMDB</h2>
            <p class="text-content-muted text-xs mb-4">Type a movie title to fetch data from The Movie Database.</p>

            <div class="flex flex-col gap-3">
                <input type="text" id="search-input" placeholder="e.g. Batman"
                       class="flex-1 bg-surface border border-surface-border text-content-primary text-sm rounded-xl px-4 py-3 outline-none focus:border-brand focus:ring-1 focus:ring-brand placeholder-content-muted transition">
                <button id="search-btn"
                        class="bg-brand hover:bg-brand-dark text-white text-sm font-medium px-5 py-3 rounded-xl transition flex items-center gap-2 flex-shrink-0">
                    <svg id="search-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                    </svg>
                    <svg id="search-spinner" class="w-4 h-4 animate-spin hidden" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                    </svg>
                    Search
                </button>
            </div>

            <!-- Results -->
            <div id="search-results" class="mt-4 space-y-2 hidden">
                <p class="text-content-muted text-xs font-medium uppercase tracking-wider mb-2">Select a movie</p>
                <div id="results-list" class="space-y-2 max-h-72 overflow-y-auto pr-1"></div>
            </div>

            <div id="search-empty" class="hidden mt-4 text-center text-content-muted text-sm py-4">
                No movies found. Try a different title.
            </div>
        </div>

        <!-- Step 2: Store form (hidden until movie selected) -->
        <div id="store-section" class="hidden">
            <form action="{{ route('store.movie') }}" method="post" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Selected movie preview -->
                <div class="bg-surface-card border border-brand/40 rounded-2xl p-5 flex items-center gap-4">
                    <img id="selected-cover" src="" alt="" class="w-14 h-20 object-cover rounded-lg bg-surface-raised flex-shrink-0">
                    <div class="min-w-0">
                        <p class="text-content-muted text-xs uppercase tracking-wider mb-1">Selected</p>
                        <p id="selected-title" class="text-content-primary font-semibold truncate"></p>
                        <p id="selected-year" class="text-content-muted text-xs mt-0.5"></p>
                    </div>
                </div>

                <input type="hidden" name="movieId" id="movie-id-input">

                <!-- Step 2: Files -->
                <div class="bg-surface-card border border-surface-border rounded-2xl p-6 space-y-5">
                    <h2 class="text-content-primary font-semibold">Step 2 — Upload files</h2>

                    <div>
                        <label class="block text-content-secondary text-xs font-medium mb-1.5">Trailer file <span class="text-content-muted">(mp4)</span></label>
                        <input type="file" name="trailer" accept="video/*"
                               class="w-full bg-surface border border-surface-border text-content-secondary text-sm rounded-xl px-4 py-3 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-brand file:text-white file:text-xs file:font-medium file:cursor-pointer hover:file:bg-brand-dark transition cursor-pointer" required>
                    </div>

                    <div>
                        <label class="block text-content-secondary text-xs font-medium mb-1.5">Movie file <span class="text-content-muted">(mp4)</span></label>
                        <input type="file" name="movie" accept="video/*"
                               class="w-full bg-surface border border-surface-border text-content-secondary text-sm rounded-xl px-4 py-3 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-brand file:text-white file:text-xs file:font-medium file:cursor-pointer hover:file:bg-brand-dark transition cursor-pointer" required>
                    </div>
                </div>

                <!-- Step 3: Type -->
                <div class="bg-surface-card border border-surface-border rounded-2xl p-6">
                    <h2 class="text-content-primary font-semibold mb-4">Step 3 — Access type</h2>
                    <div class="flex flex-col gap-3">
                        <label class="flex items-center gap-3 bg-surface border border-surface-border rounded-xl px-4 py-3 cursor-pointer hover:border-brand transition has-[:checked]:border-brand has-[:checked]:bg-brand/10">
                            <input type="radio" name="type" value="1" class="accent-brand" required>
                            <div>
                                <p class="text-content-primary text-sm font-medium">Free</p>
                                <p class="text-content-muted text-xs">All users can watch</p>
                            </div>
                        </label>
                        <label class="flex items-center gap-3 bg-surface border border-surface-border rounded-xl px-4 py-3 cursor-pointer hover:border-brand transition has-[:checked]:border-brand has-[:checked]:bg-brand/10">
                            <input type="radio" name="type" value="2" class="accent-brand">
                            <div>
                                <p class="text-content-primary text-sm font-medium">Paid</p>
                                <p class="text-content-muted text-xs">Subscribers only</p>
                            </div>
                        </label>
                    </div>
                </div>

                <button type="submit"
                        class="w-full bg-brand hover:bg-brand-dark text-white font-semibold text-sm py-3.5 rounded-xl transition">
                    Add Movie
                </button>

            </form>
        </div>

    </div>
</div>

<script>
    const searchBtn     = document.getElementById('search-btn');
    const searchInput   = document.getElementById('search-input');
    const searchIcon    = document.getElementById('search-icon');
    const searchSpinner = document.getElementById('search-spinner');
    const resultsList   = document.getElementById('results-list');
    const searchResults = document.getElementById('search-results');
    const searchEmpty   = document.getElementById('search-empty');
    const storeSection  = document.getElementById('store-section');
    const selectedTitle = document.getElementById('selected-title');
    const selectedYear  = document.getElementById('selected-year');
    const selectedCover = document.getElementById('selected-cover');
    const movieIdInput  = document.getElementById('movie-id-input');
    const csrfToken     = document.querySelector('meta[name="csrf-token"]').content;

    function setLoading(on) {
        searchIcon.classList.toggle('hidden', on);
        searchSpinner.classList.toggle('hidden', !on);
        searchBtn.disabled = on;
    }

    async function doSearch() {
        const title = searchInput.value.trim();
        if (!title) return;

        setLoading(true);
        searchResults.classList.add('hidden');
        searchEmpty.classList.add('hidden');
        storeSection.classList.add('hidden');

        try {
            const res  = await fetch("{{ route('get.movie') }}", {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-CSRF-TOKEN': csrfToken },
                body: new URLSearchParams({ title }),
            });
            const data = await res.json();

            resultsList.innerHTML = '';

            if (!Array.isArray(data) || data.length === 0) {
                searchEmpty.classList.remove('hidden');
            } else {
                data.forEach(movie => {
                    const year  = movie.release_date ? movie.release_date.substring(0, 4) : '—';
                    const cover = movie.poster_path
                        ? `https://image.tmdb.org/t/p/w92${movie.poster_path}`
                        : '';

                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'w-full flex items-center gap-3 text-left bg-surface hover:bg-surface-raised border border-surface-border hover:border-brand rounded-xl px-4 py-3 transition';
                    btn.innerHTML = `
                        ${cover ? `<img src="${cover}" class="w-8 h-12 object-cover rounded flex-shrink-0">` : '<div class="w-8 h-12 bg-surface-raised rounded flex-shrink-0"></div>'}
                        <div class="min-w-0">
                            <p class="text-content-primary text-sm font-medium truncate">${movie.title}</p>
                            <p class="text-content-muted text-xs">${year}</p>
                        </div>`;

                    btn.addEventListener('click', () => selectMovie(movie, cover));
                    resultsList.appendChild(btn);
                });
                searchResults.classList.remove('hidden');
            }
        } catch (e) {
            searchEmpty.classList.remove('hidden');
        } finally {
            setLoading(false);
        }
    }

    function selectMovie(movie, cover) {
        const year = movie.release_date ? movie.release_date.substring(0, 4) : '—';
        movieIdInput.value  = movie.id;
        selectedTitle.textContent = movie.title;
        selectedYear.textContent  = year;
        selectedCover.src = cover || '';
        selectedCover.style.display = cover ? '' : 'none';
        storeSection.classList.remove('hidden');
        storeSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    searchBtn.addEventListener('click', doSearch);
    searchInput.addEventListener('keydown', e => { if (e.key === 'Enter') { e.preventDefault(); doSearch(); } });
</script>
@endsection
