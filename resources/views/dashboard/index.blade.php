@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
    <p class="text-gray-600 mt-2">Visão geral do sistema de gestão de cursos</p>
</div>

<!-- Estatísticas Gerais -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total de Alunos</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_alunos'] }}</p>
                <p class="text-xs text-green-600 mt-1">{{ $stats['alunos_ativos'] }} ativos</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total de Cursos</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_cursos'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-purple-100 rounded-md p-3">
                <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Professores</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_professores'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-yellow-100 rounded-md p-3">
                <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Matrículas</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_matriculas'] }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Estatísticas Financeiras -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-sm font-medium text-gray-500 mb-2">Receita Total</p>
        <p class="text-3xl font-bold text-green-600">{{ number_format($stats['receita_total'], 2, ',', '.') }} €</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-sm font-medium text-gray-500 mb-2">Débitos Pendentes</p>
        <p class="text-3xl font-bold {{ $stats['debitos_pendentes'] > 0 ? 'text-red-600' : 'text-green-600' }}">
            {{ number_format($stats['debitos_pendentes'], 2, ',', '.') }} €
        </p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-sm font-medium text-gray-500 mb-2">Total de Avaliações</p>
        <p class="text-3xl font-bold text-gray-900">{{ $stats['total_avaliacoes'] }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Cursos Mais Populares -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Cursos Mais Populares</h2>
        <div class="space-y-3">
            @forelse($cursos_populares as $curso)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                    <div>
                        <p class="font-medium text-gray-900">{{ $curso->nome }}</p>
                        <p class="text-sm text-gray-500">{{ $curso->professor->nome ?? 'Sem professor' }}</p>
                    </div>
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                        {{ $curso->enrollments_count }} alunos
                    </span>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">Nenhum curso cadastrado</p>
            @endforelse
        </div>
    </div>

    <!-- Professores Mais Ativos -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Professores Mais Ativos</h2>
        <div class="space-y-3">
            @forelse($professores_ativos as $professor)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                    <div>
                        <p class="font-medium text-gray-900">{{ $professor->nome }}</p>
                        <p class="text-sm text-gray-500">{{ $professor->telemovel ?? 'Sem telefone' }}</p>
                    </div>
                    <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-medium">
                        {{ $professor->courses_count }} cursos
                    </span>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">Nenhum professor cadastrado</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Médias por Curso -->
@if($medias_por_curso->count() > 0)
<div class="bg-white rounded-lg shadow p-6 mb-8">
    <h2 class="text-xl font-semibold text-gray-900 mb-4">Médias de Notas por Curso</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Curso</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Média</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($medias_por_curso as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->nome }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded font-medium">
                                {{ number_format($item->media, 2, ',', '.') }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<!-- Matrículas Recentes -->
<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold text-gray-900 mb-4">Matrículas Recentes</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aluno</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Curso</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($matriculas_recentes as $matricula)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $matricula->student->nome }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $matricula->course->nome }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($matricula->data_matricula)->format('d/m/Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">Nenhuma matrícula recente</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

