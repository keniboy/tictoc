@extends('layouts.app')

@section('title', 'Matrículas')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-900">Matrículas</h1>
    <a href="{{ route('enrollments.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg">
        Nova Matrícula
    </a>
</div>

@if($enrollments->count() > 0)
    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aluno</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Curso</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data Matrícula</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($enrollments as $enrollment)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $enrollment->student->nome }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $enrollment->course->nome }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($enrollment->data_matricula)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('enrollments.show', $enrollment) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Ver</a>
                            <a href="{{ route('enrollments.edit', $enrollment) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Editar</a>
                            <form action="{{ route('enrollments.destroy', $enrollment) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza?');">
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
    <div class="mt-4">{{ $enrollments->links() }}</div>
@else
    <div class="bg-white shadow-sm rounded-lg p-8 text-center">
        <p class="text-gray-500 mb-4">Nenhuma matrícula cadastrada.</p>
        <a href="{{ route('enrollments.create') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg">Criar primeira matrícula</a>
    </div>
@endif
@endsection

