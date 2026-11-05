<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
   
    public function index() {
        $movies = Movie::latest()->get();

        $genreIds = $movies->flatMap(fn($m) => explode(',', $m['genre']))->unique()->values();

        $dataGenre = Genre::whereIn('id_genre', $genreIds)->orderBy('genre')->get();

        return view('movie.category', ['genre' => $dataGenre, 'movies' => $movies]);
    }
}
