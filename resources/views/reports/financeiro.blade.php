@extends('layouts.app')

@section('title', 'Relatório Financeiro')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Relatório Financeiro</h1>
        <p class="text-gray-600 mt-2">Análise completa das receitas e despesas</p>
    </div>
    <a href="{{ route('dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg">
        Voltar ao Dashboard
    </a>
</div>

<!-- Resumo Financeiro -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-sm font-medium text-gray-500 mb-2">Receita Total</p>
        <p class="text-3xl font-bold text-green-600">{{ number_format($receita_total, 2, ',', '.') }} €</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-sm font-medium text-gray-500 mb-2">Débitos Totais</p>
        <p class="text-3xl font-bold text-red-600">{{ number_format($debito_total, 2, ',', '.') }} €</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-sm font-medium text-gray-500 mb-2">Saldo</p>
        <p class="text-3xl font-bold {{ $saldo >= 0 ? 'text-green-600' : 'text-red-600' }}">
            {{ number_format($saldo, 2, ',', '.') }} €
        </p>
    </div>
</div>

<!-- Receita por Curso -->
<div class="bg-white rounded-lg shadow p-6 mb-8">
    <h2 class="text-xl font-semibold text-gray-900 mb-4">Receita por Curso</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Curso</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Receita</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Débitos</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Saldo</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($receita_por_curso as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->nome }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-green-600 font-medium">
                            {{ number_format($item->receita, 2, ',', '.') }} €
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-red-600">
                            {{ number_format($item->despesa, 2, ',', '.') }} €
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium {{ ($item->receita - $item->despesa) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ number_format($item->receita - $item->despesa, 2, ',', '.') }} €
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">Nenhum dado disponível</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Top 10 Pagamentos -->
<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold text-gray-900 mb-4">Maiores Pagamentos (Top 10)</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aluno</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Curso</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Valor</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($top_pagamentos as $pagamento)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $pagamento->enrollment->student->nome }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $pagamento->enrollment->course->nome }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($pagamento->data_pagamento)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-green-600 font-medium">
                            {{ number_format($pagamento->credito, 2, ',', '.') }} €
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">Nenhum pagamento registrado</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

