@extends('layouts.app')

@section('title', 'Nova Avaliação')

@section('content')
<div class="mb-6"><h1 class="text-3xl font-bold text-gray-900">Nova Avaliação</h1></div>
<div class="bg-white shadow-sm rounded-lg p-6">
    <form action="{{ route('evaluations.store') }}" method="POST">@csrf
        <div class="mb-4">
            <label for="enrollment_id" class="block text-sm font-medium text-gray-700 mb-2">Matrícula *</label>
            <select name="enrollment_id" id="enrollment_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Selecione uma matrícula</option>
                @foreach($enrollments as $enrollment)
                    <option value="{{ $enrollment->id }}" {{ old('enrollment_id') == $enrollment->id ? 'selected' : '' }}>
                        {{ $enrollment->student->nome }} - {{ $enrollment->course->nome }}
                    </option>
                @endforeach
            </select>
            @error('enrollment_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div class="mb-4">
            <label for="nota" class="block text-sm font-medium text-gray-700 mb-2">Nota (0-20)</label>
            <input type="number" name="nota" id="nota" value="{{ old('nota') }}" step="0.01" min="0" max="20" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            @error('nota')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div class="mb-4">
            <label for="data" class="block text-sm font-medium text-gray-700 mb-2">Data</label>
            <input type="date" name="data" id="data" value="{{ old('data', date('Y-m-d')) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            @error('data')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div class="flex items-center justify-end space-x-3">
            <a href="{{ route('evaluations.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Cancelar</a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Salvar</button>
        </div>
    </form>
</div>
@endsection

