<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Models\Professor;
use App\Models\Enrollment;
use App\Models\Evaluation;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Estatísticas Gerais
        $stats = [
            'total_alunos' => Student::count(),
            'alunos_ativos' => Student::where('ativo', true)->count(),
            'total_cursos' => Course::count(),
            'total_professores' => Professor::count(),
            'total_matriculas' => Enrollment::count(),
            'total_avaliacoes' => Evaluation::count(),
            'total_pagamentos' => Payment::count(),
        ];

        // Receita Total (soma de todos os créditos)
        $stats['receita_total'] = Payment::sum('credito');
        
        // Débitos Pendentes (débitos - créditos por matrícula)
        $stats['debitos_pendentes'] = DB::table('payments')
            ->selectRaw('SUM(debito) - SUM(credito) as saldo')
            ->value('saldo') ?? 0;

        // Cursos mais populares (top 5)
        $cursos_populares = Course::with('professor')
            ->withCount('enrollments')
            ->orderBy('enrollments_count', 'desc')
            ->limit(5)
            ->get();

        // Professores mais ativos (top 5)
        $professores_ativos = Professor::withCount('courses')
            ->orderBy('courses_count', 'desc')
            ->limit(5)
            ->get();

        // Matrículas recentes (últimas 10)
        $matriculas_recentes = Enrollment::with(['student', 'course'])
            ->latest('data_matricula')
            ->limit(10)
            ->get();

        // Média de notas por curso
        $medias_por_curso = DB::table('evaluations')
            ->join('enrollments', 'evaluations.enrollment_id', '=', 'enrollments.id')
            ->join('courses', 'enrollments.course_id', '=', 'courses.id')
            ->select('courses.nome', DB::raw('AVG(evaluations.nota) as media'))
            ->whereNotNull('evaluations.nota')
            ->groupBy('courses.id', 'courses.nome')
            ->orderBy('media', 'desc')
            ->limit(5)
            ->get();

        // Gráfico de matrículas por mês (últimos 6 meses)
        $matriculas_por_mes = Enrollment::select(
                DB::raw("DATE_TRUNC('month', data_matricula) as mes"),
                DB::raw('COUNT(*) as total')
            )
            ->where('data_matricula', '>=', now()->subMonths(6))
            ->groupBy(DB::raw("DATE_TRUNC('month', data_matricula)"))
            ->orderBy('mes')
            ->get();

        return view('dashboard.index', compact(
            'stats',
            'cursos_populares',
            'professores_ativos',
            'matriculas_recentes',
            'medias_por_curso',
            'matriculas_por_mes'
        ));
    }
}

