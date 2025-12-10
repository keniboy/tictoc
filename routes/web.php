<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return redirect()->route('courses.index');
});

// Resource Routes
Route::resource('professors', ProfessorController::class);
Route::resource('courses', CourseController::class);
Route::resource('students', StudentController::class);
Route::resource('enrollments', EnrollmentController::class);
Route::resource('evaluations', EvaluationController::class);
Route::resource('payments', PaymentController::class);
