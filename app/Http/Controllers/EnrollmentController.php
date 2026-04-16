<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
class EnrollmentController extends Controller
{
    public function enroll(Request $request, $courseId){

        $already = Enrollment::where('apprenant_id', $request->user()->id)
                             ->where('course_id', $courseId)
                             ->exists();

        if ($already) {
            return response()->json(['message' => 'Déjà inscrit.'], 409);
        }
        

        Enrollment::create([
            'apprenant_id' => $request->user()->id,
            'course_id'    => $courseId,
        ]);

        return response()->json(['message' => 'Inscrit avec succès.'], 201);
    }
    //
}
