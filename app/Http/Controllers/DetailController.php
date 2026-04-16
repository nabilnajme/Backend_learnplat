<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
class DetailController extends Controller
{

 public function index($courseId)
    {
     $course = Course::with([
        'formateur:id,name',
        'chapters',
        'quizzes',
        
    ])->findOrFail($courseId);

    return response()->json($course);
    }
    //
}
