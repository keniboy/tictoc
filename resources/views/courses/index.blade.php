@extends('layouts.app')

@section('title', 'Cursos')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-900">Cursos</h1>
    <a href="{{ route('courses.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg">
        Novo Curso
    </a>
</div>

@if($courses->count() > 0)
    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Professor</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Período</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($courses as $course)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $course->nome }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $course->professor->nome }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 font-medium">{{ number_format($course->valor, 2, ',', '.') }} €</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">
                                @if($course->data_inicio && $course->data_fim)
                                    {{ \Carbon\Carbon::parse($course->data_inicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($course->data_fim)->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('courses.show', $course) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Ver</a>
                            <a href="{{ route('courses.edit', $course) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Editar</a>
                            <form action="{{ route('courses.destroy', $course) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja remover este curso?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Remover</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $courses->links() }}
    </div>
@else
    <div class="bg-white shadow-sm rounded-lg p-8 text-center">
        <p class="text-gray-500 mb-4">Nenhum curso cadastrado.</p>
        <a href="{{ route('courses.create') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg">
            Criar primeiro curso
        </a>
    </div>
@endif
@endsection

