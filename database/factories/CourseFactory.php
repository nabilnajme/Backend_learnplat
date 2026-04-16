<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'        => $this->faker->sentence(3), 
            'description'  => $this->faker->paragraph(),
            'category'     => $this->faker->randomElement(['Frontend', 'Backend', 'DevOps', 'Database']),
            'formateur_id' => $this->faker->numberBetween(1, 4), 
            'is_published' => $this->faker->boolean(), 
        ];
    }
}
