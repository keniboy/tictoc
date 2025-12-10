<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Rotas Públicas (Autenticação)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Logout (pode ser acessado mesmo autenticado)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rotas Protegidas (Requerem Autenticação)
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Relatórios
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/alunos-por-curso', [ReportController::class, 'alunosPorCurso'])->name('alunos-por-curso');
        Route::get('/financeiro', [ReportController::class, 'financeiro'])->name('financeiro');
        Route::get('/desempenho', [ReportController::class, 'desempenho'])->name('desempenho');
    });

    // Resource Routes
    Route::resource('professors', ProfessorController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('students', StudentController::class);
    Route::resource('enrollments', EnrollmentController::class);
    Route::resource('evaluations', EvaluationController::class);
    Route::resource('payments', PaymentController::class);
});
