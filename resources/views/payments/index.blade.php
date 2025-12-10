@extends('layouts.app')

@section('title', 'Pagamentos')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-900">Pagamentos</h1>
    <a href="{{ route('payments.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg">Novo Pagamento</a>
</div>
@if($payments->count() > 0)
<div class="bg-white shadow-sm rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aluno</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Curso</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Débito</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Crédito</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Ações</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($payments as $payment)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $payment->enrollment->student->nome }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $payment->enrollment->course->nome }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($payment->data_pagamento)->format('d/m/Y') }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($payment->debito, 2, ',', '.') }} €</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-medium">{{ number_format($payment->credito, 2, ',', '.') }} €</td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('payments.show', $payment) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Ver</a>
                    <a href="{{ route('payments.edit', $payment) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Editar</a>
                    <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">Remover</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $payments->links() }}</div>
@else
<div class="bg-white shadow-sm rounded-lg p-8 text-center">
    <p class="text-gray-500 mb-4">Nenhum pagamento cadastrado.</p>
    <a href="{{ route('payments.create') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg">Criar primeiro pagamento</a>
</div>
@endif
@endsection

