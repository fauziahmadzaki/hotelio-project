<?php

namespace Database\Seeders;

use App\Models\RoomType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RoomType::insert([
           [
            "room_type_name" => "deluxe",
            ],
            [
                "room_type_name" => "super",
            ]
        ]);
    }
}
