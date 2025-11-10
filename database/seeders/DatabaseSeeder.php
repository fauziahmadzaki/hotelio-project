<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\RoomSeeder;
use Database\Seeders\FacilitySeeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'admin',
            'password' => Hash::make('admin'),
            'role' => 'admin'
        ]);

        User::factory(20)->create();

        $this->call([
            RoomTypeSeeder::class,
            FacilitySeeder::class,
            RoomSeeder::class
        ]);
    }
}
