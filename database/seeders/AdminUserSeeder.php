<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'name' => 'Admin Cinema',
            'email' => 'admin@mymupi.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        
        // Also create a regular user for testing
        \App\Models\User::create([
            'name' => 'Farhan User',
            'email' => 'farhan@user.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
    }
}
