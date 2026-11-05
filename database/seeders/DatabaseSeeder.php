<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Http;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Test account is only created locally (APP_ENV=local); the random password is printed
        if (app()->environment('local')) {
            User::factory()->create([
                'name' => 'Admin Demo',
                'email' => 'admin@demo.com',
                'password' => bcrypt('password'),
                'role' => 0,
                'is_admin' => true,
                'email_verified_at' => now(),
            ]);

            User::factory()->create([
                'name' => 'Viewer Demo',
                'email' => 'viewer@demo.com',
                'password' => bcrypt('password'),
                'role' => 0,
                'is_admin' => false,
                'email_verified_at' => now(),
            ]);

            $this->command?->info('Demo accounts created:');
            $this->command?->info('  Admin  → admin@demo.com / password');
            $this->command?->info('  Viewer → viewer@demo.com / password');
        }

        $this->call(MovieSeeder::class);
    }
}
