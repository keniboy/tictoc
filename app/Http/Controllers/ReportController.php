<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Evaluation;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Relatório de Alunos por Curso
     */
    public function alunosPorCurso()
    {
        $alunosPorCurso = Course::withCount('enrollments')
            ->with('professor')
            ->orderBy('enrollments_count', 'desc')
            ->get()
            ->map(function ($course) {
                $course->alunos = Enrollment::where('course_id', $course->id)
                    ->with('student')
                    ->get()
                    ->pluck('student');
                return $course;
            });

        return view('reports.alunos-por-curso', compact('alunosPorCurso'));
    }

    /**
     * Relatório Financeiro
     */
    public function financeiro()
    {
        // Receitas e Despesas
        $receita_total = Payment::sum('credito');
        $debito_total = Payment::sum('debito');
        $saldo = $receita_total - $debito_total;

        // Pagamentos por mês (últimos 12 meses)
        $pagamentos_por_mes = Payment::select(
                DB::raw("DATE_TRUNC('month', data_pagamento) as mes"),
                DB::raw('SUM(credito) as receita'),
                DB::raw('SUM(debito) as despesa')
            )
            ->where('data_pagamento', '>=', now()->subMonths(12))
            ->groupBy(DB::raw("DATE_TRUNC('month', data_pagamento)"))
            ->orderBy('mes')
            ->get();

        // Receita por curso
        $receita_por_curso = DB::table('payments')
            ->join('enrollments', 'payments.enrollment_id', '=', 'enrollments.id')
            ->join('courses', 'enrollments.course_id', '=', 'courses.id')
            ->select(
                'courses.nome',
                DB::raw('SUM(payments.credito) as receita'),
                DB::raw('SUM(payments.debito) as despesa')
            )
            ->groupBy('courses.id', 'courses.nome')
            ->orderBy('receita', 'desc')
            ->get();

        // Top 10 pagamentos
        $top_pagamentos = Payment::with(['enrollment.student', 'enrollment.course'])
            ->orderBy('credito', 'desc')
            ->limit(10)
            ->get();

        return view('reports.financeiro', compact(
            'receita_total',
            'debito_total',
            'saldo',
            'pagamentos_por_mes',
            'receita_por_curso',
            'top_pagamentos'
        ));
    }

    /**
     * Relatório de Desempenho (Médias de Notas)
     */
    public function desempenho()
    {
        // Média geral de todas as avaliações
        $media_geral = Evaluation::whereNotNull('nota')->avg('nota');

        // Média por curso
        $medias_por_curso = DB::table('evaluations')
            ->join('enrollments', 'evaluations.enrollment_id', '=', 'enrollments.id')
            ->join('courses', 'enrollments.course_id', '=', 'courses.id')
            ->select(
                'courses.id',
                'courses.nome',
                DB::raw('AVG(evaluations.nota) as media'),
                DB::raw('COUNT(evaluations.id) as total_avaliacoes'),
                DB::raw('MIN(evaluations.nota) as nota_minima'),
                DB::raw('MAX(evaluations.nota) as nota_maxima')
            )
            ->whereNotNull('evaluations.nota')
            ->groupBy('courses.id', 'courses.nome')
            ->orderBy('media', 'desc')
            ->get();

        // Média por aluno
        $medias_por_aluno = DB::table('evaluations')
            ->join('enrollments', 'evaluations.enrollment_id', '=', 'enrollments.id')
            ->join('students', 'enrollments.student_id', '=', 'students.id')
            ->select(
                'students.id',
                'students.nome',
                'students.email',
                DB::raw('AVG(evaluations.nota) as media'),
                DB::raw('COUNT(evaluations.id) as total_avaliacoes')
            )
            ->whereNotNull('evaluations.nota')
            ->groupBy('students.id', 'students.nome', 'students.email')
            ->having('total_avaliacoes', '>', 0)
            ->orderBy('media', 'desc')
            ->limit(20)
            ->get();

        // Distribuição de notas
        $distribuicao_notas = DB::table('evaluations')
            ->select(
                DB::raw('CASE 
                    WHEN nota < 10 THEN \'Reprovado (< 10)\'
                    WHEN nota < 14 THEN \'Suficiente (10-13)\'
                    WHEN nota < 16 THEN \'Bom (14-15)\'
                    WHEN nota < 18 THEN \'Muito Bom (16-17)\'
                    ELSE \'Excelente (18-20)\'
                END as faixa'),
                DB::raw('COUNT(*) as quantidade')
            )
            ->whereNotNull('nota')
            ->groupBy('faixa')
            ->orderByRaw('MIN(nota)')
            ->get();

        return view('reports.desempenho', compact(
            'media_geral',
            'medias_por_curso',
            'medias_por_aluno',
            'distribuicao_notas'
        ));
    }
}

