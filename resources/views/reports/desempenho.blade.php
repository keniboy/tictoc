@extends('layouts.app')

@section('title', 'Relatório de Desempenho')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Relatório de Desempenho</h1>
        <p class="text-gray-600 mt-2">Análise de notas e médias de avaliações</p>
    </div>
    <a href="{{ route('dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg">
        Voltar ao Dashboard
    </a>
</div>

<!-- Média Geral -->
<div class="bg-white rounded-lg shadow p-6 mb-8">
    <div class="text-center">
        <p class="text-sm font-medium text-gray-500 mb-2">Média Geral de Todas as Avaliações</p>
        <p class="text-5xl font-bold text-indigo-600">{{ number_format($media_geral ?? 0, 2, ',', '.') }}</p>
        <p class="text-sm text-gray-500 mt-2">Escala de 0 a 20</p>
    </div>
</div>

<!-- Médias por Curso -->
<div class="bg-white rounded-lg shadow p-6 mb-8">
    <h2 class="text-xl font-semibold text-gray-900 mb-4">Médias por Curso</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Curso</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Média</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Avaliações</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Mínima</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Máxima</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($medias_por_curso as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->nome }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                @if($item->media >= 16) bg-green-100 text-green-800
                                @elseif($item->media >= 14) bg-blue-100 text-blue-800
                                @elseif($item->media >= 10) bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ number_format($item->media, 2, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">{{ $item->total_avaliacoes }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">{{ number_format($item->nota_minima, 2, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">{{ number_format($item->nota_maxima, 2, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Nenhuma avaliação registrada</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Médias por Aluno -->
<div class="bg-white rounded-lg shadow p-6 mb-8">
    <h2 class="text-xl font-semibold text-gray-900 mb-4">Médias por Aluno (Top 20)</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aluno</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Média</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Avaliações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($medias_por_aluno as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->nome }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                @if($item->media >= 16) bg-green-100 text-green-800
                                @elseif($item->media >= 14) bg-blue-100 text-blue-800
                                @elseif($item->media >= 10) bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ number_format($item->media, 2, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">{{ $item->total_avaliacoes }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">Nenhuma avaliação registrada</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Distribuição de Notas -->
@if($distribuicao_notas->count() > 0)
<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold text-gray-900 mb-4">Distribuição de Notas</h2>
    <div class="space-y-4">
        @foreach($distribuicao_notas as $item)
            <div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700">{{ $item->faixa }}</span>
                    <span class="text-sm text-gray-500">{{ $item->quantidade }} avaliações</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ ($item->quantidade / $distribuicao_notas->sum('quantidade')) * 100 }}%"></div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif
@endsection

