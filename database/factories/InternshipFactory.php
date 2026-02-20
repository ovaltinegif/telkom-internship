<?php

namespace Database\Factories;

use App\Models\Internship;
use App\Models\User;
use App\Models\Division;
use Illuminate\Database\Eloquent\Factories\Factory;

class InternshipFactory extends Factory
{
    protected $model = Internship::class;

    public function definition(): array
    {
        return [
            'student_id' => User::factory(),
            'mentor_id' => User::factory(),
            'division_id' => Division::factory(),
            'status' => fake()->randomElement(['active', 'pending', 'finished', 'rejected', 'onboarding']),
            'start_date' => now()->subMonths(1)->format('Y-m-d'),
            'end_date' => now()->addMonths(2)->format('Y-m-d'),
            'location' => fake()->city(),
        ];
    }
}
