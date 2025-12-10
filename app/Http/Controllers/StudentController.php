<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::latest()->paginate(15);
        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:150',
            'telemovel' => 'nullable|string|max:30',
            'email' => 'required|email|max:160|unique:students,email',
            'data_nascimento' => 'nullable|date',
            'ativo' => 'boolean',
            'sexo' => 'nullable|in:M,F,O',
        ]);

        Student::create($validated);

        return redirect()->route('students.index')
            ->with('success', 'Aluno criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        $student->load('enrollments.course');
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:150',
            'telemovel' => 'nullable|string|max:30',
            'email' => 'required|email|max:160|unique:students,email,' . $student->id,
            'data_nascimento' => 'nullable|date',
            'ativo' => 'boolean',
            'sexo' => 'nullable|in:M,F,O',
        ]);

        $student->update($validated);

        return redirect()->route('students.index')
            ->with('success', 'Aluno atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Aluno removido com sucesso!');
    }
}

