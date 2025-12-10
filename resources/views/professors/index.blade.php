@extends('layouts.app')

@section('title', 'Professores')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-900">Professores</h1>
    <a href="{{ route('professors.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg">
        Novo Professor
    </a>
</div>

@if($professors->count() > 0)
    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telemóvel</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cursos</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($professors as $professor)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $professor->nome }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $professor->telemovel ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $professor->courses_count ?? $professor->courses->count() }} curso(s)
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('professors.show', $professor) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Ver</a>
                            <a href="{{ route('professors.edit', $professor) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Editar</a>
                            <form action="{{ route('professors.destroy', $professor) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja remover este professor?');">
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
        {{ $professors->links() }}
    </div>
@else
    <div class="bg-white shadow-sm rounded-lg p-8 text-center">
        <p class="text-gray-500 mb-4">Nenhum professor cadastrado.</p>
        <a href="{{ route('professors.create') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg">
            Criar primeiro professor
        </a>
    </div>
@endif
@endsection

