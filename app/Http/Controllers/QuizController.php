<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\QuizResult;
class QuizController extends Controller
{

  public function index($courseId)
    {
        $quizzes = Quiz::where('course_id', $courseId)->get();
        return response()->json($quizzes);
    }

    public function questions($id)
    {
        $quiz = Quiz::with('questions')->findOrFail($id);
        return response()->json($quiz);
    }

    public function saveResult(Request $request, $id)
    {
        $request->validate([
            'score'           => 'required|integer',
            'total_questions' => 'required|integer',
        ]);

        QuizResult::create([
            'quiz_id'         => $id,
            'apprenant_id'    => $request->user()->id,
            'score'           => $request->score,
            'total_questions' => $request->total_questions,
        ]);

        return response()->json(['message' => 'Résultat enregistré.'], 201);
    }

    // GET /api/my-results  — get all results for logged-in apprenant
    public function myResults(Request $request)
    {
        $results = QuizResult::where('apprenant_id', $request->user()->id)
                             ->with('quiz')
                             ->orderBy('passed_at', 'desc')
                             ->get();

        return response()->json($results);
    }
}
    

