<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $enrollments = Enrollment::with(['student', 'course'])->latest()->paginate(15);
        return view('enrollments.index', compact('enrollments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::where('ativo', true)->orderBy('nome')->get();
        $courses = Course::orderBy('nome')->get();
        return view('enrollments.create', compact('students', 'courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'data_matricula' => 'nullable|date',
        ], [
            'student_id.required' => 'Selecione um aluno.',
            'course_id.required' => 'Selecione um curso.',
            'student_id.exists' => 'Aluno selecionado não existe.',
            'course_id.exists' => 'Curso selecionado não existe.',
        ]);

        // Verificar se já existe matrícula
        $exists = Enrollment::where('student_id', $validated['student_id'])
            ->where('course_id', $validated['course_id'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['error' => 'Este aluno já está matriculado neste curso.'])->withInput();
        }

        Enrollment::create($validated);

        return redirect()->route('enrollments.index')
            ->with('success', 'Matrícula criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Enrollment $enrollment)
    {
        $enrollment->load(['student', 'course', 'evaluations', 'payments']);
        return view('enrollments.show', compact('enrollment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enrollment $enrollment)
    {
        $students = Student::where('ativo', true)->orderBy('nome')->get();
        $courses = Course::orderBy('nome')->get();
        return view('enrollments.edit', compact('enrollment', 'students', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Enrollment $enrollment)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'data_matricula' => 'nullable|date',
        ], [
            'student_id.required' => 'Selecione um aluno.',
            'course_id.required' => 'Selecione um curso.',
        ]);

        // Verificar se já existe matrícula (exceto a atual)
        $exists = Enrollment::where('student_id', $validated['student_id'])
            ->where('course_id', $validated['course_id'])
            ->where('id', '!=', $enrollment->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['error' => 'Este aluno já está matriculado neste curso.'])->withInput();
        }

        $enrollment->update($validated);

        return redirect()->route('enrollments.index')
            ->with('success', 'Matrícula atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();

        return redirect()->route('enrollments.index')
            ->with('success', 'Matrícula removida com sucesso!');
    }
}

