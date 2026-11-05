<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Movie;

class AddMovieController extends Controller
{   
    public function index(){
        return view("movie.add");
    }

    public function get(Request $request){
        $response = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/search/movie', [
                'query'    => $request->title,
                'language' => 'en-US',
                'page'     => 1,
            ]);

        if ($response->failed()) {
            return response()->json(['error' => 'TMDB request failed'], 502);
        }

        $data = $response->json('results', []);
        $request->session()->put('movie_data', $data);

        return response()->json($data);
    }

    public function store(Request $request){
        $request->validate([
            'movieId' => 'required',
            'type'    => 'required|in:1,2',
            'trailer' => 'required|file|mimes:mp4,mov,avi,webm|max:512000',
            'movie'   => 'required|file|mimes:mp4,mov,avi,webm|max:2048000',
        ]);

        $data = $request->session()->get('movie_data', []);
        $selected = collect($data)->firstWhere('id', (int) $request->movieId);

        abort_unless($selected, 422, 'Movie data not found in session. Please search again.');

        $trailer = $request->file('trailer')->store('trailer', 'public');
        $video   = $request->file('movie')->store('movie', 'public');

        Movie::create([
            'movie_id'     => $selected['id'],
            'title'        => $selected['title'],
            'slug'         => str_replace(' ', '-', strtolower($selected['title'])),
            'overview'     => $selected['overview'],
            'cover'        => $selected['poster_path'] ?? '',
            'release_date' => $selected['release_date'] ?? '',
            'genre'        => implode(',', $selected['genre_ids'] ?? []),
            'vote'         => $selected['vote_average'] ?? 0,
            'movie'        => '/storage/' . $video,
            'trailer'      => '/storage/' . $trailer,
            'type'         => $request->type,
        ]);

        return redirect()->route('dashboard')->with('success', '"' . $selected['title'] . '" added successfully.');
    }
    
}
