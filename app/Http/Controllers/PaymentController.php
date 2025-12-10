<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::with('enrollment.student', 'enrollment.course')
            ->latest()
            ->paginate(15);
        return view('payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $enrollments = Enrollment::with(['student', 'course'])
            ->orderBy('data_matricula', 'desc')
            ->get();
        return view('payments.create', compact('enrollments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id',
            'data_pagamento' => 'nullable|date',
            'debito' => 'nullable|numeric|min:0',
            'credito' => 'nullable|numeric|min:0',
        ], [
            'enrollment_id.required' => 'Selecione uma matrícula.',
            'debito.min' => 'O débito não pode ser negativo.',
            'credito.min' => 'O crédito não pode ser negativo.',
        ]);

        // Garantir que pelo menos um valor seja preenchido
        if (empty($validated['debito']) && empty($validated['credito'])) {
            return back()->withErrors(['error' => 'Informe pelo menos um valor (débito ou crédito).'])->withInput();
        }

        Payment::create($validated);

        return redirect()->route('payments.index')
            ->with('success', 'Pagamento registrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        $payment->load('enrollment.student', 'enrollment.course');
        return view('payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        $enrollments = Enrollment::with(['student', 'course'])
            ->orderBy('data_matricula', 'desc')
            ->get();
        return view('payments.edit', compact('payment', 'enrollments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id',
            'data_pagamento' => 'nullable|date',
            'debito' => 'nullable|numeric|min:0',
            'credito' => 'nullable|numeric|min:0',
        ], [
            'debito.min' => 'O débito não pode ser negativo.',
            'credito.min' => 'O crédito não pode ser negativo.',
        ]);

        // Garantir que pelo menos um valor seja preenchido
        if (empty($validated['debito']) && empty($validated['credito'])) {
            return back()->withErrors(['error' => 'Informe pelo menos um valor (débito ou crédito).'])->withInput();
        }

        $payment->update($validated);

        return redirect()->route('payments.index')
            ->with('success', 'Pagamento atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('payments.index')
            ->with('success', 'Pagamento removido com sucesso!');
    }
}

