<?php

namespace Database\Factories;

use App\Models\Chapter;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Chapter>
 */
class ChapterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

        'course_id' => Course::factory(), 

            // fake title
            'title' => $this->faker->sentence(4), 

            // fake content (paragraphs)
            'content' => $this->faker->paragraphs(2, true), 

            // order number (sequence inside course)
            'order_num' => $this->faker->numberBetween(1, 10),
            //
        ];
    }
}
