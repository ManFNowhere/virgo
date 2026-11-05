<a href="{{ url('/movie/'.$movie['slug']) }}"
   class="flex-shrink-0 w-36 sm:w-40 group relative overflow-hidden rounded-xl border border-surface-border bg-surface-card hover:border-brand/60 transition-all duration-200 hover:-translate-y-1 hover:shadow-lg hover:shadow-black/40">
    <div class="aspect-[2/3] overflow-hidden bg-surface-raised">
        @if ($movie['cover'])
        <img src="https://image.tmdb.org/t/p/w300{{ $movie['cover'] }}" alt="{{ $movie['title'] }}"
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        @else
        <div class="w-full h-full flex items-center justify-center">
            <svg class="w-8 h-8 text-content-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.069A1 1 0 0121 8.87v6.26a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
            </svg>
        </div>
        @endif
    </div>
    <div class="p-2.5">
        <p class="text-content-primary text-xs font-medium leading-tight line-clamp-2">{{ $movie['title'] }}</p>
        <div class="flex items-center justify-between mt-1.5">
            @if ($movie['vote'] > 0)
            <div class="flex items-center gap-1">
                <svg class="w-3 h-3 text-yellow-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                <span class="text-content-muted text-xs">{{ number_format($movie['vote'], 1) }}</span>
            </div>
            @else
            <span></span>
            @endif
            <span class="text-xs px-1.5 py-0.5 rounded-md {{ $movie['type'] == 1 ? 'bg-green-900/50 text-green-400' : 'bg-brand/20 text-brand' }}">
                {{ $movie['type'] == 1 ? 'Free' : 'Premium' }}
            </span>
        </div>
    </div>
</a>
