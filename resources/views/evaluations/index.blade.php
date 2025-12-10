@extends('layouts.app')

@section('title', 'Avaliações')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-900">Avaliações</h1>
    <a href="{{ route('evaluations.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg">Nova Avaliação</a>
</div>
@if($evaluations->count() > 0)
<div class="bg-white shadow-sm rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aluno</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Curso</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nota</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Ações</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($evaluations as $evaluation)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $evaluation->enrollment->student->nome }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $evaluation->enrollment->course->nome }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($evaluation->data)->format('d/m/Y') }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $evaluation->nota ?? '-' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('evaluations.show', $evaluation) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Ver</a>
                    <a href="{{ route('evaluations.edit', $evaluation) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Editar</a>
                    <form action="{{ route('evaluations.destroy', $evaluation) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">Remover</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $evaluations->links() }}</div>
@else
<div class="bg-white shadow-sm rounded-lg p-8 text-center">
    <p class="text-gray-500 mb-4">Nenhuma avaliação cadastrada.</p>
    <a href="{{ route('evaluations.create') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg">Criar primeira avaliação</a>
</div>
@endif
@endsection

