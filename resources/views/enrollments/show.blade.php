@extends('layouts.app')

@section('title', 'Detalhes da Matrícula')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-900">Matrícula</h1>
    <div class="space-x-3">
        <a href="{{ route('enrollments.edit', $enrollment) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg">Editar</a>
        <a href="{{ route('enrollments.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg">Voltar</a>
    </div>
</div>
<div class="bg-white shadow-sm rounded-lg p-6 mb-6">
    <h2 class="text-xl font-semibold text-gray-900 mb-4">Informações</h2>
    <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div><dt class="text-sm font-medium text-gray-500">Aluno</dt><dd class="mt-1 text-sm text-gray-900"><a href="{{ route('students.show', $enrollment->student) }}" class="text-indigo-600 hover:text-indigo-900">{{ $enrollment->student->nome }}</a></dd></div>
        <div><dt class="text-sm font-medium text-gray-500">Curso</dt><dd class="mt-1 text-sm text-gray-900"><a href="{{ route('courses.show', $enrollment->course) }}" class="text-indigo-600 hover:text-indigo-900">{{ $enrollment->course->nome }}</a></dd></div>
        <div><dt class="text-sm font-medium text-gray-500">Data Matrícula</dt><dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($enrollment->data_matricula)->format('d/m/Y') }}</dd></div>
    </dl>
</div>
@if($enrollment->evaluations->count() > 0)
<div class="bg-white shadow-sm rounded-lg p-6 mb-6">
    <h2 class="text-xl font-semibold text-gray-900 mb-4">Avaliações ({{ $enrollment->evaluations->count() }})</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50"><tr><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nota</th><th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Ações</th></tr></thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($enrollment->evaluations as $evaluation)
                <tr><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($evaluation->data)->format('d/m/Y') }}</td><td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $evaluation->nota ?? '-' }}</td><td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"><a href="{{ route('evaluations.show', $evaluation) }}" class="text-indigo-600 hover:text-indigo-900">Ver</a></td></tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@if($enrollment->payments->count() > 0)
<div class="bg-white shadow-sm rounded-lg p-6">
    <h2 class="text-xl font-semibold text-gray-900 mb-4">Pagamentos ({{ $enrollment->payments->count() }})</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50"><tr><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Débito</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Crédito</th><th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Ações</th></tr></thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($enrollment->payments as $payment)
                <tr><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($payment->data_pagamento)->format('d/m/Y') }}</td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($payment->debito, 2, ',', '.') }} €</td><td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">{{ number_format($payment->credito, 2, ',', '.') }} €</td><td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"><a href="{{ route('payments.show', $payment) }}" class="text-indigo-600 hover:text-indigo-900">Ver</a></td></tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection

