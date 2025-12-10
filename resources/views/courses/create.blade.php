@extends('layouts.app')

@section('title', 'Novo Curso')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Novo Curso</h1>
</div>

<div class="bg-white shadow-sm rounded-lg p-6">
    <form action="{{ route('courses.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="nome" class="block text-sm font-medium text-gray-700 mb-2">Nome *</label>
            <input type="text" name="nome" id="nome" value="{{ old('nome') }}" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            @error('nome')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="professor_id" class="block text-sm font-medium text-gray-700 mb-2">Professor *</label>
            <select name="professor_id" id="professor_id" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Selecione um professor</option>
                @foreach($professors as $professor)
                    <option value="{{ $professor->id }}" {{ old('professor_id') == $professor->id ? 'selected' : '' }}>
                        {{ $professor->nome }}
                    </option>
                @endforeach
            </select>
            @error('professor_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="data_inicio" class="block text-sm font-medium text-gray-700 mb-2">Data Início</label>
                <input type="date" name="data_inicio" id="data_inicio" value="{{ old('data_inicio') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                @error('data_inicio')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="data_fim" class="block text-sm font-medium text-gray-700 mb-2">Data Fim</label>
                <input type="date" name="data_fim" id="data_fim" value="{{ old('data_fim') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                @error('data_fim')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-4">
            <label for="valor" class="block text-sm font-medium text-gray-700 mb-2">Valor (€) *</label>
            <input type="number" name="valor" id="valor" value="{{ old('valor', 0) }}" step="0.01" min="0" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            @error('valor')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end space-x-3">
            <a href="{{ route('courses.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Cancelar
            </a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                Salvar
            </button>
        </div>
    </form>
</div>
@endsection

