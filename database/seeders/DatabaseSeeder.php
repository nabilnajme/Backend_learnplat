<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\Chapter;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 10 chapters for course with id = 5
        Chapter::factory()->count(10)->create([
        'course_id' => 9, // force the relation
    ]);



        Quiz::factory()->count(10)->create();
        Question::factory()->count(4)->create();

    }
}
