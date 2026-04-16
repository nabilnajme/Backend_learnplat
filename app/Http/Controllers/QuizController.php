<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
class QuizController extends Controller
{

  public function index($courseId)
    {
        $quizzes = Quiz::where('course_id', $courseId)->get();
        return response()->json($quizzes);
    }
    //
}
