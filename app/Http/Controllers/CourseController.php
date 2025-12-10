<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Professor;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::with('professor')->latest()->paginate(15);
        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $professors = Professor::orderBy('nome')->get();
        return view('courses.create', compact('professors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:150',
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
            'professor_id' => 'required|exists:professors,id',
            'valor' => 'required|numeric|min:0',
        ]);

        Course::create($validated);

        return redirect()->route('courses.index')
            ->with('success', 'Curso criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $course->load(['professor', 'enrollments.student']);
        return view('courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $professors = Professor::orderBy('nome')->get();
        return view('courses.edit', compact('course', 'professors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:150',
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
            'professor_id' => 'required|exists:professors,id',
            'valor' => 'required|numeric|min:0',
        ]);

        $course->update($validated);

        return redirect()->route('courses.index')
            ->with('success', 'Curso atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Curso removido com sucesso!');
    }
}

