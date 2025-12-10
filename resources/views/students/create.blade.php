@extends('layouts.app')

@section('title', 'Novo Aluno')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Novo Aluno</h1>
</div>

<div class="bg-white shadow-sm rounded-lg p-6">
    <form action="{{ route('students.store') }}" method="POST">
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
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="telemovel" class="block text-sm font-medium text-gray-700 mb-2">Telemóvel</label>
                <input type="text" name="telemovel" id="telemovel" value="{{ old('telemovel') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                @error('telemovel')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="data_nascimento" class="block text-sm font-medium text-gray-700 mb-2">Data de Nascimento</label>
                <input type="date" name="data_nascimento" id="data_nascimento" value="{{ old('data_nascimento') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                @error('data_nascimento')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="sexo" class="block text-sm font-medium text-gray-700 mb-2">Sexo</label>
                <select name="sexo" id="sexo"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Selecione</option>
                    <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
                    <option value="F" {{ old('sexo') == 'F' ? 'selected' : '' }}>Feminino</option>
                    <option value="O" {{ old('sexo') == 'O' ? 'selected' : '' }}>Outro</option>
                </select>
                @error('sexo')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="ativo" id="ativo" value="1" {{ old('ativo', true) ? 'checked' : '' }}
                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <label for="ativo" class="ml-2 block text-sm text-gray-900">Ativo</label>
            </div>
        </div>

        <div class="flex items-center justify-end space-x-3">
            <a href="{{ route('students.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Cancelar
            </a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                Salvar
            </button>
        </div>
    </form>
</div>
@endsection

