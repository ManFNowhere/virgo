<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Movie;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // ── Movie ──────────────────────────────────────────────

    public function editMovie(Movie $movie)
    {
        $genres = Genre::all();
        return view('admin.movie-edit', compact('movie', 'genres'));
    }

    public function updateMovie(Request $request, Movie $movie)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'overview' => 'required|string',
            'type'     => 'required|in:1,2',
        ]);

        $movie->update([
            'title'    => $request->title,
            'slug'     => str_replace(' ', '-', strtolower($request->title)),
            'overview' => $request->overview,
            'type'     => $request->type,
        ]);

        return redirect()->route('dashboard')->with('success', 'Movie updated.');
    }

    public function destroyMovie(Movie $movie)
    {
        Storage::disk('public')->delete(ltrim(str_replace('/storage/', '', $movie->movie), '/'));
        Storage::disk('public')->delete(ltrim(str_replace('/storage/', '', $movie->trailer), '/'));
        $movie->delete();

        return redirect()->route('dashboard')->with('success', 'Movie deleted.');
    }

    // ── Genre ──────────────────────────────────────────────

    public function storeGenre(Request $request)
    {
        $request->validate([
            'genre'    => 'required|string|max:100',
            'id_genre' => 'required|integer|unique:genres,id_genre',
        ]);

        Genre::create($request->only('genre', 'id_genre'));

        return redirect()->route('dashboard')->with('success', 'Genre added.');
    }

    public function updateGenre(Request $request, Genre $genre)
    {
        $request->validate(['genre' => 'required|string|max:100']);
        $genre->update(['genre' => $request->genre]);

        return redirect()->route('dashboard')->with('success', 'Genre updated.');
    }

    public function destroyGenre(Genre $genre)
    {
        $genre->delete();
        return redirect()->route('dashboard')->with('success', 'Genre deleted.');
    }

    // ── Pricing ────────────────────────────────────────────

    public function updatePricing(Request $request)
    {
        $request->validate([
            'monthly_label'  => 'required|string|max:100',
            'monthly_price'  => 'required|string|max:100',
            'monthly_stripe' => 'nullable|string|max:255',
            'yearly_label'   => 'required|string|max:100',
            'yearly_price'   => 'required|string|max:100',
            'yearly_stripe'  => 'nullable|string|max:255',
        ]);

        Setting::set('monthly_label',  $request->monthly_label);
        Setting::set('monthly_price',  $request->monthly_price);
        Setting::set('monthly_stripe', $request->monthly_stripe);
        Setting::set('yearly_label',   $request->yearly_label);
        Setting::set('yearly_price',   $request->yearly_price);
        Setting::set('yearly_stripe',  $request->yearly_stripe);

        return redirect()->route('dashboard')->with('success', 'Pricing updated.');
    }
}
