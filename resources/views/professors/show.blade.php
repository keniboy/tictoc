@extends('layouts.app')

@section('title', 'Detalhes do Professor')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-900">{{ $professor->nome }}</h1>
    <div class="space-x-3">
        <a href="{{ route('professors.edit', $professor) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg">
            Editar
        </a>
        <a href="{{ route('professors.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg">
            Voltar
        </a>
    </div>
</div>

<div class="bg-white shadow-sm rounded-lg p-6 mb-6">
    <h2 class="text-xl font-semibold text-gray-900 mb-4">Informações</h2>
    <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div>
            <dt class="text-sm font-medium text-gray-500">Nome</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ $professor->nome }}</dd>
        </div>
        <div>
            <dt class="text-sm font-medium text-gray-500">Telemóvel</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ $professor->telemovel ?? '-' }}</dd>
        </div>
    </dl>
</div>

@if($professor->courses->count() > 0)
    <div class="bg-white shadow-sm rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Cursos ({{ $professor->courses->count() }})</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nome</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Valor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Período</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($professor->courses as $course)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $course->nome }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($course->valor, 2, ',', '.') }} €</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($course->data_inicio && $course->data_fim)
                                    {{ \Carbon\Carbon::parse($course->data_inicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($course->data_fim)->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('courses.show', $course) }}" class="text-indigo-600 hover:text-indigo-900">Ver</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection

