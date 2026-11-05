<?php

namespace App\Http\Controllers;
use App\Models\Watched;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

use App\Models\Movie;
use App\Models\Genre;

class MovieController extends Controller
{
    public function index($slug){
        $movie = Movie::where("slug", $slug)->first();
        $genreIds = explode(',', $movie['genre']);
        $genre = [];
        foreach($genreIds as $genreId) {
            $get=Genre::where('id_genre', $genreId)->first();
            $genre[$genreId] = $get['genre'] ;
        }


         // get credit
         $url = "https://api.themoviedb.org/3/movie/".$movie['movie_id']."/credits?language=en-US";

         $options = [
             'http' => [
                 'header' => "Authorization: Bearer ".config('services.tmdb.token')."\r\n",
                 'method' => 'GET',
             ],
         ];
         
         $context = stream_context_create($options);
         $response = file_get_contents($url, false, $context);
         
         if ($response === false) {
             echo "Failed to fetch data from the API.";
         } else {
             $credit = json_decode($response, true);
         
             $cast = [];
             $count = 0;
             foreach ($credit["cast"] as $cr) {
                 $cast[] = [
                     'id' => $cr['id'],
                     'name' => $cr['name'],
                     'character' => $cr['character'],
                     'profile_path' => $cr['profile_path'],
                 ];
                 $count++;
                 if ($count >= 6) {
                     break;
                 }
             }
         
             $crew = [];
             foreach ($credit["crew"] as $cr) {
                 $crew[] = [
                     'id' => $cr['id'],
                     'name' => $cr['name'],
                     'job' => $cr['job'],
                 ];
             }
        
         }
         
        return view("movie.movie", ['data'=>$movie, 'genre'=>$genre, 'cast'=> $cast,'crew'=>$crew]);

    }

    public function show($slug){
        if ($slug === 'new-release') {
            $label = 'New Releases';
            $data  = Movie::latest()->get();
        } elseif ($slug === 'free') {
            $label = 'Top Free Movies';
            $data  = Movie::where('type', 1)->orderBy('watched', 'desc')->get();
        } elseif ($slug === 'watched') {
            $label = 'Top Movies';
            $data  = Movie::orderBy('watched', 'desc')->get();
        } else {
            abort(404);
        }
        return view('movie.short', ['label' => $label, 'data' => $data, 'slug' => $slug]);
    }

    public function watch($slug)
    {
        $movie = Movie::where('slug', $slug)->firstOrFail();
        $userRole = auth()->user()->role;
    
        if ($movie->type == 2 && $userRole == 0) {
            return redirect()->route('dashboard')
                ->with('demo_error', 'This movie requires a subscription. Upgrade your plan to watch.');
        }

        // record watch only once per user
        $alreadyWatched = Watched::where('user_id', auth()->id())
                                  ->where('movie_id', $movie->id)->exists();
        if (! $alreadyWatched) {
            $movie->increment('watched');
            Watched::create(['user_id' => auth()->id(), 'movie_id' => $movie->id]);
        }

        return view('movie.watch', ['movie' => $movie]);
    }
    
    public function stream($type, $filename)
    {
        abort_unless(in_array($type, ['movie', 'trailer'], true), 404);
        $path = storage_path('app/public/' . $type . '/' . basename($filename));
        abort_unless(file_exists($path), 404);
        return response()->file($path, ['Content-Type' => 'video/mp4']);
    }

    public function search(Request $request){
        $search = $request->search;
        $data = Movie::where('title','like',"%$search%")->get();

        return view('movie.search',['search'=> $request->search,'movies'=> $data ]);
    }
}
