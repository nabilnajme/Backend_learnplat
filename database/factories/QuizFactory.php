<?php

namespace Database\Factories;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Quiz>
 */
class QuizFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       return [
            'course_id' => 9, // link to random course
            'title' => $this->faker->sentence(3),              // short fake title
            'duration_minutes' => $this->faker->numberBetween(10, 120), // duration in minutes
        ];
    }
}
