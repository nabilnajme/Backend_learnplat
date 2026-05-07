<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    // GET /api/courses/{id}/chapters
    public function index($courseId)
    {
        $chapters = Chapter::where('course_id', $courseId)
                           ->orderBy('order_num')
                           ->get();
        return response()->json($chapters);
    }

    // POST /api/courses/{id}/chapters
    public function store(Request $request, $courseId)
    {
        $request->validate([
            'title'   => 'required|string|max:200',
            'content' => 'nullable|string',
        ]);

        $count   = Chapter::where('course_id', $courseId)->count();
        $chapter = Chapter::create([
            'course_id' => $courseId,
            'title'     => $request->title,
            'content'   => $request->content,
            'order_num' => $count + 1,
        ]);

        return response()->json($chapter, 201);
    }

                    // Formateur section
// GET /api/chapters/{id}
public function show($id)
{
    $chapter = Chapter::findOrFail($id);
    return response()->json($chapter);
}

    // PUT /api/chapters/{id}
    public function update(Request $request, $id)
    {
        $chapter = Chapter::findOrFail($id);

        $request->validate([
            'title'   => 'required|string|max:200',
            'content' => 'nullable|string',
        ]);

        $chapter->update([
            'title'   => $request->title,
            'content' => $request->content,
        ]);

        return response()->json($chapter);
    }

    // DELETE /api/chapters/{id}
    public function destroy($id)
    {
        $chapter = Chapter::findOrFail($id);
        $chapter->delete();
        return response()->json(['message' => 'Chapitre supprimé.']);
    }


}