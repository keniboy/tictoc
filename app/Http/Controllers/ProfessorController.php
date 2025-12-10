<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use Illuminate\Http\Request;

class ProfessorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $professors = Professor::withCount('courses')->latest()->paginate(15);
        return view('professors.index', compact('professors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('professors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:150',
            'telemovel' => 'nullable|string|max:30',
        ]);

        Professor::create($validated);

        return redirect()->route('professors.index')
            ->with('success', 'Professor criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Professor $professor)
    {
        $professor->load('courses');
        return view('professors.show', compact('professor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Professor $professor)
    {
        return view('professors.edit', compact('professor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Professor $professor)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:150',
            'telemovel' => 'nullable|string|max:30',
        ]);

        $professor->update($validated);

        return redirect()->route('professors.index')
            ->with('success', 'Professor atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Professor $professor)
    {
        $professor->delete();

        return redirect()->route('professors.index')
            ->with('success', 'Professor removido com sucesso!');
    }
}

