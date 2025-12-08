<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Movie::create([
            'title' => 'Avatar: The Way of Water',
            'description' => 'Jake Sully lives with his newfound family formed on the extrasolar moon Pandora. Once a familiar threat returns to finish what was previously started, Jake must work with Neytiri and the army of the Na\'vi race to protect their home.',
            'genre' => 'Sci-Fi, Action',
            'poster' => 'avatar2.jpg',
            'duration_minutes' => 192,
            'rating' => 9.2,
            'release_date' => '2022-12-16',
        ]);

        \App\Models\Movie::create([
            'title' => 'Spider-Man: No Way Home',
            'description' => 'With Spider-Man\'s identity now revealed, Peter asks Doctor Strange for help. When a spell goes wrong, dangerous foes from other worlds start to appear, forcing Peter to discover what it truly means to be Spider-Man.',
            'genre' => 'Action, Adventure',
            'poster' => 'spiderman_nwh.jpg',
            'duration_minutes' => 148,
            'rating' => 8.9,
            'release_date' => '2021-12-17',
        ]);
        
        \App\Models\Movie::create([
            'title' => 'Oppenheimer',
            'description' => 'The story of American scientist J. Robert Oppenheimer and his role in the development of the atomic bomb.',
            'genre' => 'Biography, Drama',
            'poster' => 'oppenheimer.jpg',
            'duration_minutes' => 180,
            'rating' => 9.5,
            'release_date' => '2023-07-21',
        ]);

         \App\Models\Movie::create([
            'title' => 'The Batman',
            'description' => 'When the Riddler, a sadistic serial killer, begins murdering key political figures in Gotham, Batman is forced to investigate the city\'s hidden corruption and question his family\'s involvement.',
            'genre' => 'Action, Crime',
            'poster' => 'batman.jpg',
            'duration_minutes' => 176,
            'rating' => 8.5,
            'release_date' => '2022-03-04',
        ]);
    }
}
