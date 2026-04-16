<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\QuizController;




Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login'])->name('login');;

// Route::get('/courses', [CourseController::class, 'index']);
// Route::post('/quiz/{id}/submit', [QuizController::class, 'submit']);

Route::middleware('auth:sanctum')->group(function () {
 
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/courses', [CourseController::class, 'index']);
    Route::post('/dashboard/apprenant/enroll/{id}', [CourseController::class, 'enroll']);
    Route::get('/dashboard/apprenant/enroll/enrollments', [CourseController::class, 'myenroll']);
    Route::put('/dashboard/apprenant/profile', [AuthController::class, 'updateProfile']);
    Route::put('/dashboard/apprenant/profile/password', [AuthController::class, 'updatePassword']);
    Route::get('/courses/{courseId}/details', [DetailController::class, 'index']);
    Route::get('/quizzes/{id}/questions', [QuizController::class, 'questions']);
    Route::post('/quizzes/{id}/result', [QuizController::class, 'saveResult']);
    Route::get('/my-results',[QuizController::class, 'myResults']);
    

});
