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

                   // Formateur Section

    // GET /api/formateur/stats
    public function stats(Request $request)
{
    $formateurId = $request->user()->id;

    // total courses created by this formateur
    $totalCourses = Course::where('formateur_id', $formateurId)->count();

    // total students enrolled in his courses
    $totalStudents = Enrollment::whereHas('course', function ($q) use ($formateurId) {
        $q->where('formateur_id', $formateurId);
    })->count();

    // published vs draft
    $published = Course::where('formateur_id', $formateurId)->where('is_published', 1)->count();
    $draft     = Course::where('formateur_id', $formateurId)->where('is_published', 0)->count();

    return response()->json([
        'total_courses'  => $totalCourses,
        'total_students' => $totalStudents,
        'published'      => $published,
        'draft'          => $draft,
    ]);
}

// GET /api/formateur/courses — all courses by this formateur
public function myCourses(Request $request)
{
    $courses = Course::where('formateur_id', $request->user()->id)
                     ->withCount('enrollments')
                     ->latest()
                     ->get();

    return response()->json($courses);
}

// POST /api/courses — create a course
public function store(Request $request)
{
    $request->validate([
        'title'       => 'required|string|max:200',
        'description' => 'nullable|string',
        'category'    => 'nullable|string',
    ]);

    $course = Course::create([
        'title'        => $request->title,
        'description'  => $request->description,
        'category'     => $request->category,
        'formateur_id' => $request->user()->id,
        'is_published' => 0,
    ]);

    return response()->json($course, 201);
}

// PUT /api/courses/{id}/publish
public function publish(Request $request, $id)
{
    $course = Course::where('id', $id)
                    ->where('formateur_id', $request->user()->id)
                    ->firstOrFail();

    $course->is_published = 1;
    $course->save();

    return response()->json(['message' => 'Cours publié.']);
}


// DELETE /api/courses/{id}
public function destroy(Request $request, $id)
{
    $course = Course::where('id', $id)
                    ->where('formateur_id', $request->user()->id)
                    ->firstOrFail();
    $course->delete();
    return response()->json(['message' => 'Cours supprimé.']);
}

// PUT /api/courses/{id}
public function update(Request $request, $id)
{
    $course = Course::where('id', $id)
                    ->where('formateur_id', $request->user()->id)
                    ->firstOrFail();

    $request->validate([
        'title'       => 'required|string|max:200',
        'description' => 'nullable|string',
        'category'    => 'nullable|string',
    ]);

    $course->update([
        'title'       => $request->title,
        'description' => $request->description,
        'category'    => $request->category,
    ]);

    return response()->json($course);
}
    
}
