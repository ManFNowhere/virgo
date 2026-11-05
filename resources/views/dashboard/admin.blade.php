@extends('layouts.app')

@section('container')
<div class="min-h-screen bg-surface pt-20 pb-10 px-4 sm:px-8">
    <div class="max-w-6xl mx-auto space-y-6">

        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-content-primary text-2xl font-bold">Admin Dashboard</h1>
                <p class="text-content-muted text-sm mt-1">{{ $user->name }}</p>
            </div>
            <form action="{{ url('/logout') }}" method="post" class="hidden md:block">
                @csrf
                {{-- <button type="submit" class="text-red-400 hover:text-red-300 text-sm transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Sign Out
                </button> --}}
                <button type="submit" class="text-white hover:text-red-300 text-sm transition bg-red-500 hover:bg-red-400 py-2 px-4 w-full mx-auto rounded-md">
                    Sign Out
                </button>
            </form>
        </div>

        @if (session('success'))
        <div class="flex items-center gap-3 bg-green-900/40 border border-green-700 text-green-400 text-sm rounded-xl px-4 py-3">
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
        @endif

        <!-- Stats -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="bg-surface-card border border-surface-border rounded-2xl p-4">
                <p class="text-content-muted text-xs uppercase tracking-wider mb-1">Total Movies</p>
                <p class="text-content-primary text-3xl font-bold">{{ $movies->count() }}</p>
            </div>
            <div class="bg-surface-card border border-surface-border rounded-2xl p-4">
                <p class="text-content-muted text-xs uppercase tracking-wider mb-1">Free</p>
                <p class="text-content-primary text-3xl font-bold">{{ $movies->where('type', 1)->count() }}</p>
            </div>
            <div class="bg-surface-card border border-surface-border rounded-2xl p-4">
                <p class="text-content-muted text-xs uppercase tracking-wider mb-1">Paid</p>
                <p class="text-content-primary text-3xl font-bold">{{ $movies->where('type', 2)->count() }}</p>
            </div>
            <div class="bg-surface-card border border-surface-border rounded-2xl p-4">
                <p class="text-content-muted text-xs uppercase tracking-wider mb-1">Genres</p>
                <p class="text-content-primary text-3xl font-bold">{{ $genres->count() }}</p>
            </div>
        </div>

        <!-- Tabs -->
        <div x-data="{ tab: '{{ session('_tab', 'movies') }}' }">

            <div class="flex gap-1 bg-surface-card border border-surface-border rounded-xl p-1 w-fit">
                <button @click="tab = 'movies'" :class="tab === 'movies' ? 'bg-brand text-white' : 'text-content-muted hover:text-content-primary'"
                        class="text-sm font-medium px-4 py-2 rounded-lg transition">Movies</button>
                <button @click="tab = 'genres'" :class="tab === 'genres' ? 'bg-brand text-white' : 'text-content-muted hover:text-content-primary'"
                        class="text-sm font-medium px-4 py-2 rounded-lg transition">Categories</button>
                <button @click="tab = 'pricing'" :class="tab === 'pricing' ? 'bg-brand text-white' : 'text-content-muted hover:text-content-primary'"
                        class="text-sm font-medium px-4 py-2 rounded-lg transition">Pricing</button>
            </div>

            {{-- ── MOVIES TAB ── --}}
            <div x-show="tab === 'movies'" x-cloak class="space-y-4 mt-4">
                <div class="flex justify-end">
                    <a href="{{ route('add.movie') }}"
                       class="bg-brand hover:bg-brand-dark text-white text-sm font-medium px-4 py-2.5 rounded-xl transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add Movie
                    </a>
                </div>

                <div class="bg-surface-card border border-surface-border rounded-2xl overflow-hidden">
                    @if ($movies->isEmpty())
                        <div class="px-6 py-10 text-center text-content-muted text-sm">
                            No movies yet. <a href="{{ route('add.movie') }}" class="text-brand hover:text-brand-light">Add one now.</a>
                        </div>
                    @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-content-muted text-xs uppercase tracking-wider border-b border-surface-border">
                                    <th class="text-left px-6 py-3">Title</th>
                                    <th class="text-left px-6 py-3 hidden md:table-cell">Release</th>
                                    <th class="text-left px-6 py-3">Type</th>
                                    <th class="text-left px-6 py-3 hidden sm:table-cell">Views</th>
                                    <th class="text-right px-6 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-surface-border">
                                @foreach ($movies as $movie)
                                <tr class="hover:bg-surface-raised transition">
                                    <td class="px-6 py-3 text-content-primary font-medium max-w-[200px] truncate">{{ $movie->title }}</td>
                                    <td class="px-6 py-3 text-content-muted hidden md:table-cell">{{ $movie->release_date }}</td>
                                    <td class="px-6 py-3">
                                        @if ($movie->type == 1)
                                            <span class="text-xs bg-green-900/40 text-green-400 border border-green-800 px-2 py-0.5 rounded-full">Free</span>
                                        @else
                                            <span class="text-xs bg-brand/20 text-brand border border-brand/30 px-2 py-0.5 rounded-full">Paid</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3 text-content-muted hidden sm:table-cell">{{ $movie->watched }}</td>
                                    <td class="px-6 py-3 text-right">
                                        <div class="flex items-center justify-end gap-3">
                                            <a href="{{ route('admin.movie.edit', $movie) }}"
                                               class="text-content-muted hover:text-content-primary transition text-xs">Edit</a>
                                            <form action="{{ route('admin.movie.destroy', $movie) }}" method="post"
                                                  onsubmit="return confirm('Delete {{ addslashes($movie->title) }}?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-300 transition text-xs">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>

            {{-- ── GENRES TAB ── --}}
            <div x-show="tab === 'genres'" x-cloak class="space-y-4 mt-4">

                {{-- Add genre form --}}
                <div class="bg-surface-card border border-surface-border rounded-2xl p-5">
                    <h3 class="text-content-primary font-semibold mb-4">Add Category</h3>
                    <form action="{{ route('admin.genre.store') }}" method="post" class="flex flex-col sm:flex-row gap-3">
                        @csrf
                        <input type="number" name="id_genre" placeholder="TMDB Genre ID"
                               class="bg-surface border border-surface-border text-content-primary text-sm rounded-xl px-4 py-2.5 outline-none focus:border-brand focus:ring-1 focus:ring-brand transition w-full sm:w-40" required>
                        <input type="text" name="genre" placeholder="Genre name"
                               class="bg-surface border border-surface-border text-content-primary text-sm rounded-xl px-4 py-2.5 outline-none focus:border-brand focus:ring-1 focus:ring-brand transition flex-1" required>
                        <button type="submit"
                                class="bg-brand hover:bg-brand-dark text-white text-sm font-medium px-4 py-2.5 rounded-xl transition flex-shrink-0">
                            Add
                        </button>
                    </form>
                    @error('genre') <p class="text-red-400 text-xs mt-2">{{ $message }}</p> @enderror
                    @error('id_genre') <p class="text-red-400 text-xs mt-2">{{ $message }}</p> @enderror
                </div>

                {{-- Genre list --}}
                <div class="bg-surface-card border border-surface-border rounded-2xl overflow-hidden">
                    @if ($genres->isEmpty())
                        <div class="px-6 py-10 text-center text-content-muted text-sm">No genres yet.</div>
                    @else
                    <div class="divide-y divide-surface-border">
                        @foreach ($genres as $genre)
                        <div x-data="{ editing: false }" class="flex items-center justify-between px-5 py-3 hover:bg-surface-raised transition">
                            <div class="flex items-center gap-4 flex-1 min-w-0">
                                <span class="text-content-muted text-xs font-mono w-10 flex-shrink-0">#{{ $genre->id_genre }}</span>
                                <span x-show="!editing" class="text-content-primary text-sm truncate">{{ $genre->genre }}</span>
                                <form x-show="editing" action="{{ route('admin.genre.update', $genre) }}" method="post" class="flex gap-2 flex-1">
                                    @csrf @method('PATCH')
                                    <input type="text" name="genre" value="{{ $genre->genre }}"
                                           class="bg-surface border border-surface-border text-content-primary text-sm rounded-lg px-3 py-1.5 outline-none focus:border-brand flex-1">
                                    <button type="submit" class="text-brand hover:text-brand-light text-xs font-medium transition">Save</button>
                                    <button type="button" @click="editing = false" class="text-content-muted hover:text-content-primary text-xs transition">Cancel</button>
                                </form>
                            </div>
                            <div x-show="!editing" class="flex items-center gap-3 flex-shrink-0 ml-3">
                                <button @click="editing = true" class="text-content-muted hover:text-content-primary transition text-xs">Edit</button>
                                <form action="{{ route('admin.genre.destroy', $genre) }}" method="post"
                                      onsubmit="return confirm('Delete {{ addslashes($genre->genre) }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 transition text-xs">Delete</button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            {{-- ── PRICING TAB ── --}}
            <div x-show="tab === 'pricing'" x-cloak class="mt-4">
                <div class="bg-surface-card border border-surface-border rounded-2xl p-6">
                    <h3 class="text-content-primary font-semibold mb-1">Subscription Pricing</h3>
                    <p class="text-content-muted text-xs mb-6">Set the labels and Stripe Price IDs for each tier.</p>

                    <form action="{{ route('admin.pricing.update') }}" method="post" class="space-y-6">
                        @csrf

                        {{-- Monthly --}}
                        <div class="border border-surface-border rounded-xl p-5 space-y-4">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xs bg-surface-raised text-content-secondary border border-surface-border px-2 py-0.5 rounded-full font-medium">Monthly</span>
                            </div>
                            <div class="grid sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-content-secondary text-xs font-medium mb-1.5">Label</label>
                                    <input type="text" name="monthly_label" value="{{ old('monthly_label', $settings['monthly_label'] ?? 'Monthly') }}"
                                           placeholder="e.g. Monthly"
                                           class="w-full bg-surface border border-surface-border text-content-primary text-sm rounded-xl px-4 py-3 outline-none focus:border-brand focus:ring-1 focus:ring-brand transition" required>
                                </div>
                                <div>
                                    <label class="block text-content-secondary text-xs font-medium mb-1.5">Price display</label>
                                    <input type="text" name="monthly_price" value="{{ old('monthly_price', $settings['monthly_price'] ?? '') }}"
                                           placeholder="e.g. Rp 50.000 / month"
                                           class="w-full bg-surface border border-surface-border text-content-primary text-sm rounded-xl px-4 py-3 outline-none focus:border-brand focus:ring-1 focus:ring-brand transition" required>
                                </div>
                            </div>
                            <div>
                                <label class="block text-content-secondary text-xs font-medium mb-1.5">Stripe Price ID</label>
                                <input type="text" name="monthly_stripe" value="{{ old('monthly_stripe', $settings['monthly_stripe'] ?? env('STRIPE_MONTHLY')) }}"
                                       placeholder="price_xxxxxxxxxxxxxxxxxx"
                                       class="w-full bg-surface border border-surface-border text-content-primary text-sm rounded-xl px-4 py-3 outline-none focus:border-brand focus:ring-1 focus:ring-brand transition font-mono">
                            </div>
                        </div>

                        {{-- Yearly --}}
                        <div class="border border-surface-border rounded-xl p-5 space-y-4">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xs bg-brand/20 text-brand border border-brand/30 px-2 py-0.5 rounded-full font-medium">Yearly</span>
                                <span class="text-content-muted text-xs">Best value</span>
                            </div>
                            <div class="grid sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-content-secondary text-xs font-medium mb-1.5">Label</label>
                                    <input type="text" name="yearly_label" value="{{ old('yearly_label', $settings['yearly_label'] ?? 'Yearly') }}"
                                           placeholder="e.g. Yearly"
                                           class="w-full bg-surface border border-surface-border text-content-primary text-sm rounded-xl px-4 py-3 outline-none focus:border-brand focus:ring-1 focus:ring-brand transition" required>
                                </div>
                                <div>
                                    <label class="block text-content-secondary text-xs font-medium mb-1.5">Price display</label>
                                    <input type="text" name="yearly_price" value="{{ old('yearly_price', $settings['yearly_price'] ?? '') }}"
                                           placeholder="e.g. Rp 500.000 / year"
                                           class="w-full bg-surface border border-surface-border text-content-primary text-sm rounded-xl px-4 py-3 outline-none focus:border-brand focus:ring-1 focus:ring-brand transition" required>
                                </div>
                            </div>
                            <div>
                                <label class="block text-content-secondary text-xs font-medium mb-1.5">Stripe Price ID</label>
                                <input type="text" name="yearly_stripe" value="{{ old('yearly_stripe', $settings['yearly_stripe'] ?? env('STRIPE_YEARLY')) }}"
                                       placeholder="price_xxxxxxxxxxxxxxxxxx"
                                       class="w-full bg-surface border border-surface-border text-content-primary text-sm rounded-xl px-4 py-3 outline-none focus:border-brand focus:ring-1 focus:ring-brand transition font-mono">
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                    class="bg-brand hover:bg-brand-dark text-white text-sm font-medium px-5 py-2.5 rounded-xl transition">
                                Save pricing
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>{{-- end x-data tabs --}}
    </div>
    <div class="md:hidden mt-4 items-center mx-auto">
        <form action="{{ url('/logout') }}" method="post" class="">
            @csrf
            <button type="submit" class="text-white hover:text-red-300 text-sm transition bg-red-500 hover:bg-red-400 py-2 w-full mx-auto rounded-md">
                Sign Out
            </button>
        </form>
    </div>
</div>
@endsection
