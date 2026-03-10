<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\DepartmentController;
use App\Http\Controllers\Api\Admin\CourseController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Teacher\GradeController;
use App\Http\Controllers\Api\Student\EnrollmentController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::middleware('isAdmin')->group(function () {
        Route::apiResource('departments', DepartmentController::class);
        Route::apiResource('courses', CourseController::class);
        Route::apiResource('users', UserController::class)->only([
            'index', 'store', 'destroy'
        ]);

    });

    Route::middleware('isTeacher')->group(function () {
        Route::get('/my-courses', [GradeController::class, 'myCourses']);
        Route::post('/grades', [GradeController::class, 'store']);
    });    

    Route::middleware('isStudent')->group(function () {
        Route::get('/my-enrollments', [EnrollmentController::class, 'myCourses']);
        Route::post('/enroll', [EnrollmentController::class, 'enroll']);
        Route::get('/my-grades', [EnrollmentController::class, 'myGrades']);
    });
});
