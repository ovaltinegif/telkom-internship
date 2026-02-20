<?php

namespace Database\Factories;

use App\Models\Attendance;
use App\Models\Internship;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    protected $model = Attendance::class;

    public function definition(): array
    {
        return [
            'internship_id' => Internship::factory(),
            'date' => fake()->date(),
            'status' => fake()->randomElement(['present', 'permit', 'sick']),
            'check_in_time' => '08:00:00',
            'check_out_time' => '17:00:00',
            'check_in_lat' => fake()->latitude(),
            'check_in_long' => fake()->longitude(),
        ];
    }
}
