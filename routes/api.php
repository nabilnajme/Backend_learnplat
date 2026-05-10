<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\AdminController;



Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login'])->name('login');;

// Route::get('/courses', [CourseController::class, 'index']);
// Route::post('/quiz/{id}/submit', [QuizController::class, 'submit']);

Route::middleware('auth:sanctum')->group(function () {
 
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/courses', [CourseController::class, 'index']);


    // ======================================Students==========================================//
    Route::post('/dashboard/apprenant/enroll/{id}', [CourseController::class, 'enroll']);
    Route::get('/dashboard/apprenant/enroll/enrollments', [CourseController::class, 'myenroll']);
    Route::put('/dashboard/apprenant/profile', [AuthController::class, 'updateProfile']);
    Route::put('/dashboard/apprenant/profile/password', [AuthController::class, 'updatePassword']);
    Route::get('/courses/{courseId}/details', [DetailController::class, 'index']);
    Route::get('/quizzes/{id}/questions', [QuizController::class, 'questions']);
    Route::post('/quizzes/{id}/result', [QuizController::class, 'saveResult']);
    Route::get('/my-results',[QuizController::class, 'myResults']);







       //=======================================================Formateur ====================================================//

       //Remeber to add a middleware 




    Route::get('/formateur/stats',          [CourseController::class, 'stats']);
    Route::get('/formateur/courses',        [CourseController::class, 'myCourses']);
    Route::post('/courses',                 [CourseController::class, 'store']);
    Route::get('/formateur/latest',         [CourseController::class, 'latest']);
    Route::put('/courses/{id}/publish',     [CourseController::class, 'publish']);




    // ===============================================course CRUD==========================//
    Route::put('/courses/{id}',             [CourseController::class, 'update']);
    Route::delete('/courses/{id}',          [CourseController::class, 'destroy']);

    // ====================================chapters===============================================//
    Route::get('/courses/{id}/chapters',    [ChapterController::class, 'index']);
    Route::post('/courses/{id}/chapters',   [ChapterController::class, 'store']);
    Route::put('/chapters/{id}',            [ChapterController::class, 'update']);
    Route::delete('/chapters/{id}',         [ChapterController::class, 'destroy']);
    Route::get('/chapters/{id}',            [ChapterController::class, 'show']);

    //===========================================Quizs=========================================//
    Route::get('/courses/{id}/quizzes',          [QuizController::class, 'index']);
    Route::post('/courses/{id}/quizzes',         [QuizController::class, 'store']);
    Route::put('/quizzes/{id}',                  [QuizController::class, 'update']);
    Route::delete('/quizzes/{id}',               [QuizController::class, 'destroy']);
    Route::get('/courses/{id}/quiz-analytics',   [QuizController::class, 'analytics']);




    // ============================================questions==========================================//
    Route::post('/quizzes/{id}/questions',       [QuizController::class, 'storeQuestion']);
    Route::delete('/questions/{id}',             [QuizController::class, 'destroyQuestion']);

    // =======================================Admin ============================================//
 


    Route::get('/admin/stats',            [AdminController::class, 'stats']);
    Route::get('/admin/users',            [AdminController::class, 'users']);
    Route::delete('/admin/users/{id}',    [AdminController::class, 'deleteUser']);
    Route::get('/admin/courses',          [AdminController::class, 'courses']);
    Route::delete('/admin/courses/{id}',  [AdminController::class, 'deleteCourse']);

});
