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
        Course::factory()->count(8)->create();
        Chapter::factory()->count(8)->create();




        Quiz::factory()->count(4)->create();
        Question::factory()->count(4)->create();

    }
}
