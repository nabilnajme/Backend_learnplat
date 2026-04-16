<?php

namespace App\Http\Controllers;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(){

       $courses = Course::with('formateur:id,name')
                         ->where('is_published', 1)
                         ->latest()
                         ->get();
        return response()->json($courses);
    }


    // this for student enrollements post
     public function enroll(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        // Check if already enrolled
        $exists = Enrollment::where('apprenant_id', $request->user()->id)
                             ->where('course_id', $id)
                             ->exists();
        if ($exists) {
            return response()->json(['message' => 'Déjà inscrit à ce cours.'], 409);
        }

        Enrollment::create([
            'apprenant_id' => $request->user()->id,
            'course_id'    => $id,
            'enrolled_at'  => now(),
        ]);

        return response()->json(['message' => 'Inscription réussie.'], 201);
    }



    public function myenroll(Request $request){
        
    $enrollments = Enrollment::where('apprenant_id', $request->user()->id)
                             ->with('course.formateur:id,name')
                             ->get();

    $courses = $enrollments->map(function ($e) {
        return $e->course;
    });
    
    
    return response()->json($courses);

    }
    
}
