@extends('layouts.app')

@section('title', 'Detalhes do Aluno')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-900">{{ $student->nome }}</h1>
    <div class="space-x-3">
        <a href="{{ route('students.edit', $student) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg">
            Editar
        </a>
        <a href="{{ route('students.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg">
            Voltar
        </a>
    </div>
</div>

<div class="bg-white shadow-sm rounded-lg p-6 mb-6">
    <h2 class="text-xl font-semibold text-gray-900 mb-4">Informações</h2>
    <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div>
            <dt class="text-sm font-medium text-gray-500">Nome</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ $student->nome }}</dd>
        </div>
        <div>
            <dt class="text-sm font-medium text-gray-500">Email</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ $student->email }}</dd>
        </div>
        <div>
            <dt class="text-sm font-medium text-gray-500">Telemóvel</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ $student->telemovel ?? '-' }}</dd>
        </div>
        <div>
            <dt class="text-sm font-medium text-gray-500">Data de Nascimento</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ $student->data_nascimento ? \Carbon\Carbon::parse($student->data_nascimento)->format('d/m/Y') : '-' }}</dd>
        </div>
        <div>
            <dt class="text-sm font-medium text-gray-500">Sexo</dt>
            <dd class="mt-1 text-sm text-gray-900">
                @if($student->sexo == 'M') Masculino
                @elseif($student->sexo == 'F') Feminino
                @elseif($student->sexo == 'O') Outro
                @else - @endif
            </dd>
        </div>
        <div>
            <dt class="text-sm font-medium text-gray-500">Status</dt>
            <dd class="mt-1">
                @if($student->ativo)
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Ativo</span>
                @else
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inativo</span>
                @endif
            </dd>
        </div>
    </dl>
</div>

@if($student->enrollments->count() > 0)
    <div class="bg-white shadow-sm rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Cursos Matriculados ({{ $student->enrollments->count() }})</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Curso</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data Matrícula</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($student->enrollments as $enrollment)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $enrollment->course->nome }}</td>
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

