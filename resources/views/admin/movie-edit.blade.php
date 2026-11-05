@extends('layouts.app')

@section('container')
<div class="min-h-screen bg-surface pt-20 pb-10 px-4 sm:px-8">
    <div class="max-w-2xl mx-auto">

        <div class="flex items-center gap-3 mb-8">
            <a href="{{ route('dashboard') }}" class="text-content-muted hover:text-content-primary transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="text-content-primary text-2xl font-bold">Edit Movie</h1>
        </div>

        <div class="bg-surface-card border border-surface-border rounded-2xl p-6 space-y-5">
            <form action="{{ route('admin.movie.update', $movie) }}" method="post">
                @csrf
                @method('PATCH')

                <div>
                    <label class="block text-content-secondary text-xs font-medium mb-1.5">Title</label>
                    <input type="text" name="title" value="{{ old('title', $movie->title) }}"
                           class="w-full bg-surface border border-surface-border text-content-primary text-sm rounded-xl px-4 py-3 outline-none focus:border-brand focus:ring-1 focus:ring-brand transition" required>
                    @error('title') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-content-secondary text-xs font-medium mb-1.5">Overview</label>
                    <textarea name="overview" rows="4"
                              class="w-full bg-surface border border-surface-border text-content-primary text-sm rounded-xl px-4 py-3 outline-none focus:border-brand focus:ring-1 focus:ring-brand transition resize-none" required>{{ old('overview', $movie->overview) }}</textarea>
                    @error('overview') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-content-secondary text-xs font-medium mb-1.5">Type</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="type" value="1" {{ $movie->type == 1 ? 'checked' : '' }} class="accent-brand">
                            <span class="text-content-secondary text-sm">Free</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="type" value="2" {{ $movie->type == 2 ? 'checked' : '' }} class="accent-brand">
                            <span class="text-content-secondary text-sm">Paid</span>
                        </label>
                    </div>
                    @error('type') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <a href="{{ route('dashboard') }}"
                       class="text-content-secondary hover:text-content-primary text-sm font-medium px-4 py-2.5 rounded-xl bg-surface-raised transition">
                        Cancel
                    </a>
                    <button type="submit"
                            class="bg-brand hover:bg-brand-dark text-white text-sm font-medium px-5 py-2.5 rounded-xl transition">
                        Save changes
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
