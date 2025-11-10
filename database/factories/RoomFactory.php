<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'room_name' => ucfirst($this->faker->words(2, true)), // Contoh: Deluxe Suite
            'room_code' => strtoupper($this->faker->bothify('R-###')), // Contoh: R-101
            'room_description' => $this->faker->paragraph(3),
            'room_capacity' => $this->faker->numberBetween(1, 6),
            'room_price' => $this->faker->numberBetween(150000, 2000000),
            'image' => 'images/room.jpg',
            'room_type_id' => $this->faker->numberBetween(1, 2),
            'room_status' => $this->faker->randomElement(['available', 'booked', 'maintenance']),
        ];
    }
}
