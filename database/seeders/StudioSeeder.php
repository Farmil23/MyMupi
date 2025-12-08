<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StudioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Studio::create([
            'name' => 'Studio 1 (Regular)',
            'capacity' => 50,
        ]);
        
        \App\Models\Studio::create([
            'name' => 'Studio 2 (Regular)',
            'capacity' => 50,
        ]);

        \App\Models\Studio::create([
            'name' => 'Studio 3 (Gold Class)',
            'capacity' => 20,
        ]);
    }
}
