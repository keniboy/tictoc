@extends('layouts.app')

@section('title', 'Novo Professor')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Novo Professor</h1>
</div>

<div class="bg-white shadow-sm rounded-lg p-6">
    <form action="{{ route('professors.store') }}" method="POST">
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
            <label for="telemovel" class="block text-sm font-medium text-gray-700 mb-2">Telemóvel</label>
            <input type="text" name="telemovel" id="telemovel" value="{{ old('telemovel') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            @error('telemovel')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end space-x-3">
            <a href="{{ route('professors.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Cancelar
            </a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                Salvar
            </button>
        </div>
    </form>
</div>
@endsection

