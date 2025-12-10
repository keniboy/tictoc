@extends('layouts.app')

@section('title', 'Detalhes do Curso')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-900">{{ $course->nome }}</h1>
    <div class="space-x-3">
        <a href="{{ route('courses.edit', $course) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg">
            Editar
        </a>
        <a href="{{ route('courses.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg">
            Voltar
        </a>
    </div>
</div>

<div class="bg-white shadow-sm rounded-lg p-6 mb-6">
    <h2 class="text-xl font-semibold text-gray-900 mb-4">Informações</h2>
    <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div>
            <dt class="text-sm font-medium text-gray-500">Nome</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ $course->nome }}</dd>
        </div>
        <div>
            <dt class="text-sm font-medium text-gray-500">Professor</dt>
            <dd class="mt-1 text-sm text-gray-900">
                <a href="{{ route('professors.show', $course->professor) }}" class="text-indigo-600 hover:text-indigo-900">
                    {{ $course->professor->nome }}
                </a>
            </dd>
        </div>
        <div>
            <dt class="text-sm font-medium text-gray-500">Valor</dt>
            <dd class="mt-1 text-sm text-gray-900 font-medium">{{ number_format($course->valor, 2, ',', '.') }} €</dd>
        </div>
        <div>
            <dt class="text-sm font-medium text-gray-500">Período</dt>
            <dd class="mt-1 text-sm text-gray-900">
                @if($course->data_inicio && $course->data_fim)
                    {{ \Carbon\Carbon::parse($course->data_inicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($course->data_fim)->format('d/m/Y') }}
                @else
                    -
                @endif
            </dd>
        </div>
    </dl>
</div>

@if($course->enrollments->count() > 0)
    <div class="bg-white shadow-sm rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Alunos Matriculados ({{ $course->enrollments->count() }})</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aluno</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data Matrícula</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($course->enrollments as $enrollment)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $enrollment->student->nome }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $enrollment->student->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($enrollment->data_matricula)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('enrollments.show', $enrollment) }}" class="text-indigo-600 hover:text-indigo-900">Ver</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection

