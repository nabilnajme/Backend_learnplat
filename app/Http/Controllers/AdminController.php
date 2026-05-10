<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Quiz;
use App\Models\QuizResult;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // GET /api/admin/stats
    public function stats()
    {
        return response()->json([
            'total_users'      => User::count(),
            'total_apprenants' => User::where('role', 'apprenant')->count(),
            'total_formateurs' => User::where('role', 'formateur')->count(),
            'total_courses'    => Course::count(),
            'published_courses'=> Course::where('is_published', 1)->count(),
            'total_enrollments'=> Enrollment::count(),
            'total_quizzes'    => Quiz::count(),
            'total_results'    => QuizResult::count(),
        ]);
    }

    // GET /api/admin/users
    public function users()
    {
        $users = User::latest()->get();
        return response()->json($users);
    }

    // DELETE /api/admin/users/{id}
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'Utilisateur supprimé.']);
    }

    // GET /api/admin/courses
    public function courses()
    {
        $courses = Course::with('formateur:id,name')
                         ->withCount('enrollments')
                         ->latest()
                         ->get();
        return response()->json($courses);
    }

    // DELETE /api/admin/courses/{id}
    public function deleteCourse($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return response()->json(['message' => 'Cours supprimé.']);
    }
}