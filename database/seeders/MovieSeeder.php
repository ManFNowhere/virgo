<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class MovieSeeder extends Seeder
{
    public function run(): void
    {
        // Copy demo videos into storage so the /storage/ path works
        foreach (['movie' => 'demo_movie.mp4', 'trailer' => 'demo_trailer.mp4'] as $dir => $file) {
            $src  = public_path("vids/{$file}");
            $dest = "public/{$dir}/{$file}";
            if (file_exists($src) && ! Storage::exists($dest)) {
                Storage::put($dest, file_get_contents($src));
            }
        }

        $moviePath   = '/storage/movie/demo_movie.mp4';
        $trailerPath = '/storage/trailer/demo_trailer.mp4';

        // ── Genres ─────────────────────────────────────────────────────
        $genres = [
            ['id_genre' => 28,    'genre' => 'Action'],
            ['id_genre' => 12,    'genre' => 'Adventure'],
            ['id_genre' => 16,    'genre' => 'Animation'],
            ['id_genre' => 35,    'genre' => 'Comedy'],
            ['id_genre' => 80,    'genre' => 'Crime'],
            ['id_genre' => 18,    'genre' => 'Drama'],
            ['id_genre' => 14,    'genre' => 'Fantasy'],
            ['id_genre' => 27,    'genre' => 'Horror'],
            ['id_genre' => 9648,  'genre' => 'Mystery'],
            ['id_genre' => 10749, 'genre' => 'Romance'],
            ['id_genre' => 878,   'genre' => 'Sci-Fi'],
            ['id_genre' => 53,    'genre' => 'Thriller'],
            ['id_genre' => 10752, 'genre' => 'War'],
        ];

        foreach ($genres as $g) {
            Genre::firstOrCreate(['id_genre' => $g['id_genre']], ['genre' => $g['genre']]);
        }

        // ── Movies ─────────────────────────────────────────────────────
        // type 1 = free, type 2 = paid
        $movies = [
            // Action / Adventure
            [
                'movie_id' => 299536, 'title' => 'Avengers: Infinity War',
                'overview' => 'The Avengers and their allies must be willing to sacrifice all in an attempt to defeat the powerful Thanos before his blitz of devastation and ruin puts an end to the universe.',
                'cover' => '/7WsyChQLEftFiDOVTGkv3hFpyyt.jpg', 'release_date' => '2018-04-27',
                'genre' => '12,28,878', 'vote' => '8.3', 'type' => 2,
            ],
            [
                'movie_id' => 155, 'title' => 'The Dark Knight',
                'overview' => 'When the menace known as the Joker wreaks havoc and chaos on the people of Gotham, Batman must accept one of the greatest psychological and physical tests of his ability to fight injustice.',
                'cover' => '/qJ2tW6WMUDux911r6m7haRef0WH.jpg', 'release_date' => '2008-07-18',
                'genre' => '28,80,18', 'vote' => '8.5', 'type' => 2,
            ],
            [
                'movie_id' => 157336, 'title' => 'Interstellar',
                'overview' => "A team of explorers travel through a wormhole in space in an attempt to ensure humanity's survival.",
                'cover' => '/gEU2QniE6E77NI6lCU6MxlNBvIx.jpg', 'release_date' => '2014-11-05',
                'genre' => '878,12,18', 'vote' => '8.4', 'type' => 2,
            ],
            [
                'movie_id' => 109445, 'title' => 'Frozen',
                'overview' => 'Fearless optimist Anna teams up with Kristoff and his loyal reindeer Sven and sets off on an epic journey to find her sister Elsa, whose icy powers have trapped the kingdom of Arendelle in eternal winter.',
                'cover' => '/kgwjIb2JDHRhNk13lmSxiClFjVk.jpg', 'release_date' => '2013-11-27',
                'genre' => '16,12,14,10749', 'vote' => '7.3', 'type' => 1,
            ],
            [
                'movie_id' => 27205, 'title' => 'Inception',
                'overview' => 'A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea into the mind of a C.E.O.',
                'cover' => '/xlaY2zyzMfkhk0HSC5VUwzoZPU1.jpg', 'release_date' => '2010-07-16',
                'genre' => '28,878,12', 'vote' => '8.4', 'type' => 2,
            ],
            // Crime / Thriller
            [
                'movie_id' => 238, 'title' => 'The Godfather',
                'overview' => 'Spanning the years 1945 to 1955, a chronicle of the fictional Italian-American Corleone crime family. When organized crime family patriarch Vito Corleone barely survives an attempt on his life, his youngest son, Michael, steps in to take care of the would-be killers.',
                'cover' => '/3bhkrj58Vtu7enYsLegHnDmni0.jpg', 'release_date' => '1972-03-14',
                'genre' => '18,80', 'vote' => '8.7', 'type' => 2,
            ],
            [
                'movie_id' => 769, 'title' => 'GoodFellas',
                'overview' => "The story of Henry Hill and his life through the teen years into the years of mafia, covering his relationship with his wife Karen Hill and his mob partners Jimmy Conway and Tommy DeVito in the Italian-American mob.",
                'cover' => '/aKuFiU82s5ISJpGZp7YkIr3kCUd.jpg', 'release_date' => '1990-09-12',
                'genre' => '18,80', 'vote' => '8.5', 'type' => 2,
            ],
            [
                'movie_id' => 680, 'title' => 'Pulp Fiction',
                'overview' => 'A burger-loving hit man, his philosophical partner, a drug-addled gangster\'s moll and a washed-up boxer converge in this sprawling, comedic crime caper.',
                'cover' => '/d5iIlFn5s0ImszYzBPb8JPIfbXD.jpg', 'release_date' => '1994-09-10',
                'genre' => '53,80', 'vote' => '8.5', 'type' => 2,
            ],
            [
                'movie_id' => 807, 'title' => 'Se7en',
                'overview' => 'Two homicide detectives are on a desperate hunt for a serial killer whose crimes are based on the seven deadly sins in this dark and haunting film.',
                'cover' => '/69Sns8WoET6CfaYlIkHbla4l7nC.jpg', 'release_date' => '1995-09-22',
                'genre' => '80,18,9648,53', 'vote' => '8.4', 'type' => 1,
            ],
            [
                'movie_id' => 550, 'title' => 'Fight Club',
                'overview' => 'A ticking-time-bomb insomniac and a slippery soap salesman channel primal male aggression into a shocking new form of therapy.',
                'cover' => '/jSziioSwPVrOy9Yow3XhWIBDjq1.jpg', 'release_date' => '1999-10-15',
                'genre' => '18', 'vote' => '8.4', 'type' => 2,
            ],
            // Sci-Fi
            [
                'movie_id' => 603, 'title' => 'The Matrix',
                'overview' => 'Set in the 22nd century, The Matrix tells the story of a computer hacker who joins a group of underground insurgents fighting the vast and powerful computers who now rule the earth.',
                'cover' => '/f89U3ADr1oiB1s9GkdPOEpXUk5H.jpg', 'release_date' => '1999-03-30',
                'genre' => '28,878', 'vote' => '8.2', 'type' => 1,
            ],
            [
                'movie_id' => 11, 'title' => 'Star Wars',
                'overview' => 'Princess Leia is captured and held hostage by the evil Imperial forces in their effort to take over the galactic Empire.',
                'cover' => '/6FfCtAuVAW8XJjZ7eWeLibRLWTw.jpg', 'release_date' => '1977-05-25',
                'genre' => '12,28,878', 'vote' => '8.2', 'type' => 1,
            ],
            [
                'movie_id' => 348, 'title' => 'Alien',
                'overview' => 'During its return to the earth, commercial spaceship Nostromo intercepts a distress signal from a distant planet.',
                'cover' => '/vfrQk5IPloGg1v9Rzbh2Eg3VGyM.jpg', 'release_date' => '1979-05-25',
                'genre' => '27,878', 'vote' => '8.1', 'type' => 2,
            ],
            [
                'movie_id' => 424, 'title' => "Schindler's List",
                'overview' => "In German-occupied Poland during World War II, industrialist Oskar Schindler gradually becomes concerned for his Jewish workforce after witnessing their persecution by the Nazis.",
                'cover' => '/sF1U4EUQS8YHUYjNl3pMGNIQyr0.jpg', 'release_date' => '1993-11-30',
                'genre' => '18,10752', 'vote' => '8.6', 'type' => 1,
            ],
            [
                'movie_id' => 98, 'title' => 'Gladiator',
                'overview' => 'In the year 180, the death of emperor Marcus Aurelius throws the Roman Empire into chaos. Maximus is one of the Roman army\'s most capable and trusted generals and a key advisor to the emperor.',
                'cover' => '/aDb548BOkFfI4nFm0kx8A3Ezh7H.jpg', 'release_date' => '2000-05-05',
                'genre' => '28,12,18', 'vote' => '8.2', 'type' => 2,
            ],
            // Drama
            [
                'movie_id' => 278, 'title' => 'The Shawshank Redemption',
                'overview' => 'Framed in the 1940s for the double murder of his wife and her lover, upstanding banker Andy Dufresne begins a new life at the Shawshank prison, where he puts his accounting skills to work for an amoral warden.',
                'cover' => '/lyQBXAljque4ZcbTF2eaFqixraL.jpg', 'release_date' => '1994-09-23',
                'genre' => '18,80', 'vote' => '8.7', 'type' => 1,
            ],
            [
                'movie_id' => 240, 'title' => 'The Godfather Part II',
                'overview' => 'In the continuing saga of the Corleone crime family, a young Vito Corleone grows up in Sicily and in 1910s New York.',
                'cover' => '/hek3koDUyRQk7FIhPXsa6mT2Zc3.jpg', 'release_date' => '1974-12-20',
                'genre' => '18,80', 'vote' => '8.6', 'type' => 1,
            ],
            [
                'movie_id' => 857, 'title' => 'Saving Private Ryan',
                'overview' => 'As U.S. troops storm the beaches of Normandy, three brothers lie dead on the battlefield, with a fourth trapped behind enemy lines. Ranger captain John Miller and seven men are tasked with penetrating German-held territory to rescue Private James Ryan.',
                'cover' => '/uqx37cS8cpHg8U35f9U5IBlrCV3.jpg', 'release_date' => '1998-07-24',
                'genre' => '18,10752,28', 'vote' => '8.2', 'type' => 1,
            ],
            [
                'movie_id' => 13, 'title' => 'Forrest Gump',
                'overview' => 'A man with a low IQ has accomplished great things in his life and been present during significant historical events — in each case, far exceeding what anyone imagined he could do.',
                'cover' => '/arw2vcBveWOVZr6pxd9XTd1TdQa.jpg', 'release_date' => '1994-07-06',
                'genre' => '35,18,10749', 'vote' => '8.5', 'type' => 1,
            ],
            // Horror / Mystery
            [
                'movie_id' => 694, 'title' => 'The Shining',
                'overview' => 'Jack Torrance accepts a caretaker job at the Overlook Hotel, where he, along with his wife Wendy and their son Danny, must live isolated from the rest of the world for the winter.',
                'cover' => '/nRj5511mZdTl4saWEPoj9QroTIu.jpg', 'release_date' => '1980-05-23',
                'genre' => '27', 'vote' => '8.4', 'type' => 2,
            ],
            [
                'movie_id' => 539, 'title' => 'Psycho',
                'overview' => 'When larcenous real estate clerk Marion Crane goes on the lam with $40,000 in stolen cash and checks into a remote motel run by the affable but highly strung Norman Bates.',
                'cover' => '/yz4QVqPx3h1hD1DfqqQkCq3rmxW.jpg', 'release_date' => '1960-06-22',
                'genre' => '27,9648,53', 'vote' => '8.5', 'type' => 1,
            ],
            [
                'movie_id' => 745891, 'title' => 'Get Out',
                'overview' => "Now that Chris and his girlfriend, Rose, have reached the meet-the-parents milestone of dating, she invites him for a weekend getaway upstate with Missy and Dean.",
                'cover' => '/tFXcEccSQMf3lfhfXKSU9iRBpa3.jpg', 'release_date' => '2017-02-24',
                'genre' => '27,9648,53', 'vote' => '7.7', 'type' => 1,
            ],
            // Animation
            [
                'movie_id' => 10681, 'title' => 'WALL·E',
                'overview' => "WALL·E is the last robot left on an Earth that has been abandoned by humans. He spends his days tidying up the planet, one piece of garbage at a time.",
                'cover' => '/hbhFnRzzg6ZDmm8YAmxBnQpQIPh.jpg', 'release_date' => '2008-06-27',
                'genre' => '16,12,878,10749', 'vote' => '8.4', 'type' => 1,
            ],
            [
                'movie_id' => 129, 'title' => 'Spirited Away',
                'overview' => "In the middle of her family's move to the suburbs, a sullen 10-year-old girl wanders into a world ruled by gods, witches, and spirits.",
                'cover' => '/39wmItIWsg5sZMyRUHLkWBcuVCM.jpg', 'release_date' => '2003-03-28',
                'genre' => '16,12,14', 'vote' => '8.5', 'type' => 2,
            ],
            [
                'movie_id' => 862, 'title' => 'Toy Story',
                'overview' => "Led by Woody, Andy's toys live happily in his room until Andy's birthday brings Buzz Lightyear onto the scene. Afraid of losing his place in Andy's heart, Woody plots against Buzz.",
                'cover' => '/uXDfjJbdP4ijW5hWSBrPrlKpxab.jpg', 'release_date' => '1995-11-22',
                'genre' => '16,35,12,14', 'vote' => '8.0', 'type' => 1,
            ],
            // Comedy
            [
                'movie_id' => 105, 'title' => 'Back to the Future',
                'overview' => 'Eighties teenager Marty McFly is accidentally sent back in time to 1955, inadvertently disrupting his parents\' first meeting and threatening his very existence.',
                'cover' => '/fNOH9f1aA7XRTzl1sAOx9iF553Q.jpg', 'release_date' => '1985-07-03',
                'genre' => '12,35,878', 'vote' => '8.3', 'type' => 1,
            ],
            [
                'movie_id' => 218, 'title' => 'The Terminator',
                'overview' => 'In the post-apocalyptic future, reigning tyrannical supercomputers teleport a cyborg assassin known as the Terminator back to 1984 to kill Sarah Connor.',
                'cover' => '/gmGO0N9Ft2LQZ33FbgXF3WUQJsm.jpg', 'release_date' => '1984-10-26',
                'genre' => '28,878', 'vote' => '8.0', 'type' => 1,
            ],
            // War / Fantasy
            [
                'movie_id' => 120, 'title' => 'The Lord of the Rings: The Fellowship of the Ring',
                'overview' => 'Young hobbit Frodo Baggins, after inheriting a mysterious ring from his uncle Bilbo, must leave his home in order to keep it from the clutches of its evil creator.',
                'cover' => '/6oom5QYQ2yQTMJIbnvbkBL9cHo6.jpg', 'release_date' => '2001-12-19',
                'genre' => '12,14,28', 'vote' => '8.4', 'type' => 2,
            ],
            [
                'movie_id' => 122, 'title' => 'The Lord of the Rings: The Return of the King',
                'overview' => "Aragorn is revealed as the heir to the ancient kings as he and Gandalf lead the world of Men against Sauron's army to draw his gaze from Frodo and Sam as they approach Mount Doom with the One Ring.",
                'cover' => '/rCzpDGLbOoPwLjy3OAm5NUPOTrC.jpg', 'release_date' => '2003-12-17',
                'genre' => '12,14,28', 'vote' => '8.5', 'type' => 2,
            ],
            [
                'movie_id' => 8587, 'title' => 'The Lion King',
                'overview' => 'A young lion prince is cast out of his pride by his cruel uncle, who claims he killed his father. While the uncle rules with an iron paw, the prince grows up beyond the Savannah, living by a philosophy: No worries for the rest of your days.',
                'cover' => '/sKCr78MXSLixwmZ8DyJLrpMsd15.jpg', 'release_date' => '1994-06-24',
                'genre' => '16,18,12,10749', 'vote' => '8.3', 'type' => 1,
            ],
            [
                'movie_id' => 497698, 'title' => 'Black Widow',
                'overview' => "Natasha Romanoff confronts the darker parts of her ledger when a dangerous conspiracy with ties to her past arises.",
                'cover' => '/qAZ0pzat24kLdO3o8ejmbLxyOac.jpg', 'release_date' => '2021-07-07',
                'genre' => '28,12,878', 'vote' => '7.3', 'type' => 1,
            ],
        ];

        foreach ($movies as $data) {
            Movie::firstOrCreate(
                ['movie_id' => $data['movie_id']],
                array_merge($data, [
                    'slug'    => str_replace(' ', '-', strtolower($data['title'])),
                    'watched' => rand(0, 5000),
                    'movie'   => $moviePath,
                    'trailer' => $trailerPath,
                ])
            );
        }

        $this->command?->info('30 movies and ' . count($genres) . ' genres seeded.');
    }
}
