<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Facility::insert([
            [
                'facility_name' => 'Wifi',
            ],
            [
                'facility_name' => 'TV',
            ],
            [
                'facility_name' => 'AC',
            ],
            [
                'facility_name' => 'Kasur Single Bed',
            ],
            [
                'facility_name' => 'Kasur Double Bed',
            ],
            [
                'facility_name' => 'Kasur King Bed',
            ],
            [
                'facility_name' => 'Kasur Queen Bed',
            ],
            [
                'facility_name' => 'Kasur Twin Bed',
            ],
            [
                'facility_name' => 'Kasur Sofa Bed',
            ],
            [
                'facility_name' => 'Kolam Renang',
            ],
            [
                'facility_name' => 'Kasur Sofa Bed',
            ],
        ]);
    }
}
