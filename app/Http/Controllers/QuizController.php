<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\QuizResult;
use App\Models\Question;

class QuizController extends Controller
{
    // ====================================================Students======================================//

       public function index($courseId)
    {
        $quizzes = Quiz::where('course_id', $courseId)
                       ->withCount('results')
                       ->get();
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

    
    public function myResults(Request $request)
    {
        $results = QuizResult::where('apprenant_id', $request->user()->id)
                             ->with('quiz')
                             ->orderBy('passed_at', 'desc')
                             ->get();
        return response()->json($results);
    }

// =====================================================Formateur=========================================================//

   
    public function store(Request $request, $courseId)
    {
        $request->validate([
            'title'            => 'required|string|max:200',
            'duration_minutes' => 'required|integer|min:1',
        ]);

        $quiz = Quiz::create([
            'course_id'        => $courseId,
            'title'            => $request->title,
            'duration_minutes' => $request->duration_minutes,
        ]);

        return response()->json($quiz, 201);
    }

    
    public function update(Request $request, $id)
    {
        $quiz = Quiz::findOrFail($id);

        $request->validate([
            'title'            => 'required|string|max:200',
            'duration_minutes' => 'required|integer|min:1',
        ]);

        $quiz->update([
            'title'            => $request->title,
            'duration_minutes' => $request->duration_minutes,
        ]);

        return response()->json($quiz);
    }

    
    public function destroy($id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();
        return response()->json(['message' => 'Quiz supprimé.']);
    }

    // POST /api/quizzes/{id}/questions  — add a question
    public function storeQuestion(Request $request, $id)
    {
        $request->validate([
            'question_text'  => 'required|string',
            'option_a'       => 'required|string',
            'option_b'       => 'required|string',
            'option_c'       => 'required|string',
            'option_d'       => 'required|string',
            'correct_option' => 'required|in:a,b,c,d',
        ]);

        $question = Question::create([
            'quiz_id'        => $id,
            'question_text'  => $request->question_text,
            'option_a'       => $request->option_a,
            'option_b'       => $request->option_b,
            'option_c'       => $request->option_c,
            'option_d'       => $request->option_d,
            'correct_option' => $request->correct_option,
        ]);

        return response()->json($question, 201);
    }

    // DELETE /api/questions/{id}
    public function destroyQuestion($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();
        return response()->json(['message' => 'Question supprimée.']);
    }

    // GET /api/courses/{id}/quiz-analytics
    public function analytics($courseId)
    {
        // get all quizzes for this course
        $quizIds = Quiz::where('course_id', $courseId)->pluck('id');
        

        // all results for those quizzes
        $results = QuizResult::whereIn('quiz_id', $quizIds)->get();

        $total   = $results->count();
        $passed  = $results->filter(fn($r) => $r->score / max($r->total_questions, 1) >= 0.7)->count();
        $avgScore = $total === 0 ? 0 :
            round($results->sum(fn($r) => ($r->score / max($r->total_questions, 1)) * 100) / $total);
        $successRate = $total === 0 ? 0 : round(($passed / $total) * 100);

        return response()->json([
            'total_attempts'  => $total,
            'passed'          => $passed,
            'avg_score'       => $avgScore,
            'success_rate'    => $successRate,
        ]);
    }

    
}