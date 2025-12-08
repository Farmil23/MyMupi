<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ShowtimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Avatar 2 Showtimes
        $avatar = \App\Models\Movie::where('title', 'like', '%Avatar%')->first();
        if ($avatar) {
            \App\Models\Showtime::create([
                'movie_id' => $avatar->id,
                'studio_id' => 1,
                'start_time' => now()->addDays(1)->setHour(14)->setMinute(0),
                'price' => 50000
            ]);
            \App\Models\Showtime::create([
                'movie_id' => $avatar->id,
                'studio_id' => 3, // VIP
                'start_time' => now()->addDays(1)->setHour(19)->setMinute(0),
                'price' => 100000
            ]);
        }

        // Spiderman Showtimes
        $spiderman = \App\Models\Movie::where('title', 'like', '%Spider%')->first();
        if ($spiderman) {
            \App\Models\Showtime::create([
                'movie_id' => $spiderman->id,
                'studio_id' => 2,
                'start_time' => now()->addDays(1)->setHour(16)->setMinute(30),
                'price' => 50000
            ]);
        }
    }
}
