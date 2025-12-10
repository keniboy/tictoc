<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $evaluations = Evaluation::with('enrollment.student', 'enrollment.course')
            ->latest()
            ->paginate(15);
        return view('evaluations.index', compact('evaluations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $enrollments = Enrollment::with(['student', 'course'])
            ->orderBy('data_matricula', 'desc')
            ->get();
        return view('evaluations.create', compact('enrollments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id',
            'nota' => 'nullable|numeric|min:0|max:20',
            'data' => 'nullable|date',
        ], [
            'enrollment_id.required' => 'Selecione uma matrícula.',
            'nota.max' => 'A nota máxima é 20.',
        ]);

        Evaluation::create($validated);

        return redirect()->route('evaluations.index')
            ->with('success', 'Avaliação criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Evaluation $evaluation)
    {
        $evaluation->load('enrollment.student', 'enrollment.course');
        return view('evaluations.show', compact('evaluation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Evaluation $evaluation)
    {
        $enrollments = Enrollment::with(['student', 'course'])
            ->orderBy('data_matricula', 'desc')
            ->get();
        return view('evaluations.edit', compact('evaluation', 'enrollments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Evaluation $evaluation)
    {
        $validated = $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id',
            'nota' => 'nullable|numeric|min:0|max:20',
            'data' => 'nullable|date',
        ], [
            'nota.max' => 'A nota máxima é 20.',
        ]);

        $evaluation->update($validated);

        return redirect()->route('evaluations.index')
            ->with('success', 'Avaliação atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evaluation $evaluation)
    {
        $evaluation->delete();

        return redirect()->route('evaluations.index')
            ->with('success', 'Avaliação removida com sucesso!');
    }
}

