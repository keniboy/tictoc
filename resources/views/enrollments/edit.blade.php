@extends('layouts.app')

@section('title', 'Editar Matrícula')

@section('content')
<div class="mb-6"><h1 class="text-3xl font-bold text-gray-900">Editar Matrícula</h1></div>
<div class="bg-white shadow-sm rounded-lg p-6">
    <form action="{{ route('enrollments.update', $enrollment) }}" method="POST">@csrf @method('PUT')
        <div class="mb-4">
            <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">Aluno *</label>
            <select name="student_id" id="student_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Selecione um aluno</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}" {{ old('student_id', $enrollment->student_id) == $student->id ? 'selected' : '' }}>{{ $student->nome }}</option>
                @endforeach
            </select>
            @error('student_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div class="mb-4">
            <label for="course_id" class="block text-sm font-medium text-gray-700 mb-2">Curso *</label>
            <select name="course_id" id="course_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Selecione um curso</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ old('course_id', $enrollment->course_id) == $course->id ? 'selected' : '' }}>{{ $course->nome }}</option>
                @endforeach
            </select>
            @error('course_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div class="mb-4">
            <label for="data_matricula" class="block text-sm font-medium text-gray-700 mb-2">Data Matrícula</label>
            <input type="date" name="data_matricula" id="data_matricula" value="{{ old('data_matricula', $enrollment->data_matricula->format('Y-m-d')) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            @error('data_matricula')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div class="flex items-center justify-end space-x-3">
            <a href="{{ route('enrollments.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Cancelar</a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Atualizar</button>
        </div>
    </form>
</div>
@endsection

