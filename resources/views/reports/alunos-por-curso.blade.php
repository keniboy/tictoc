@extends('layouts.app')

@section('title', 'Relatório - Alunos por Curso')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Relatório: Alunos por Curso</h1>
        <p class="text-gray-600 mt-2">Listagem completa de alunos matriculados em cada curso</p>
    </div>
    <a href="{{ route('dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg">
        Voltar ao Dashboard
    </a>
</div>

@forelse($alunosPorCurso as $curso)
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">{{ $curso->nome }}</h2>
                <p class="text-sm text-gray-500">Professor: {{ $curso->professor->nome ?? 'Não definido' }}</p>
            </div>
            <span class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full font-medium">
                {{ $curso->enrollments_count }} aluno(s)
            </span>
        </div>

        @if($curso->alunos->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nome</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Telefone</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($curso->alunos as $aluno)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <a href="{{ route('students.show', $aluno) }}" class="text-indigo-600 hover:text-indigo-900">
                                        {{ $aluno->nome }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $aluno->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $aluno->telemovel ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($aluno->ativo)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Ativo</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inativo</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-4">Nenhum aluno matriculado neste curso</p>
        @endif
    </div>
@empty
    <div class="bg-white rounded-lg shadow p-8 text-center">
        <p class="text-gray-500">Nenhum curso cadastrado</p>
    </div>
@endforelse
@endsection

