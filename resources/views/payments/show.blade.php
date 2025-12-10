@extends('layouts.app')

@section('title', 'Detalhes do Pagamento')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-900">Pagamento</h1>
    <div class="space-x-3">
        <a href="{{ route('payments.edit', $payment) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg">Editar</a>
        <a href="{{ route('payments.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg">Voltar</a>
    </div>
</div>
<div class="bg-white shadow-sm rounded-lg p-6">
    <h2 class="text-xl font-semibold text-gray-900 mb-4">Informações</h2>
    <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div><dt class="text-sm font-medium text-gray-500">Aluno</dt><dd class="mt-1 text-sm text-gray-900"><a href="{{ route('students.show', $payment->enrollment->student) }}" class="text-indigo-600 hover:text-indigo-900">{{ $payment->enrollment->student->nome }}</a></dd></div>
        <div><dt class="text-sm font-medium text-gray-500">Curso</dt><dd class="mt-1 text-sm text-gray-900"><a href="{{ route('courses.show', $payment->enrollment->course) }}" class="text-indigo-600 hover:text-indigo-900">{{ $payment->enrollment->course->nome }}</a></dd></div>
        <div><dt class="text-sm font-medium text-gray-500">Data Pagamento</dt><dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($payment->data_pagamento)->format('d/m/Y') }}</dd></div>
        <div><dt class="text-sm font-medium text-gray-500">Débito</dt><dd class="mt-1 text-sm text-gray-900 font-medium">{{ number_format($payment->debito, 2, ',', '.') }} €</dd></div>
        <div><dt class="text-sm font-medium text-gray-500">Crédito</dt><dd class="mt-1 text-sm text-green-600 font-medium">{{ number_format($payment->credito, 2, ',', '.') }} €</dd></div>
    </dl>
</div>
@endsection

