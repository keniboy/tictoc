@extends('layouts.app')

@section('title', 'Editar Pagamento')

@section('content')
<div class="mb-6"><h1 class="text-3xl font-bold text-gray-900">Editar Pagamento</h1></div>
<div class="bg-white shadow-sm rounded-lg p-6">
    <form action="{{ route('payments.update', $payment) }}" method="POST">@csrf @method('PUT')
        <div class="mb-4">
            <label for="enrollment_id" class="block text-sm font-medium text-gray-700 mb-2">Matrícula *</label>
            <select name="enrollment_id" id="enrollment_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Selecione uma matrícula</option>
                @foreach($enrollments as $enrollment)
                    <option value="{{ $enrollment->id }}" {{ old('enrollment_id', $payment->enrollment_id) == $enrollment->id ? 'selected' : '' }}>
                        {{ $enrollment->student->nome }} - {{ $enrollment->course->nome }}
                    </option>
                @endforeach
            </select>
            @error('enrollment_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div class="mb-4">
            <label for="data_pagamento" class="block text-sm font-medium text-gray-700 mb-2">Data Pagamento</label>
            <input type="date" name="data_pagamento" id="data_pagamento" value="{{ old('data_pagamento', $payment->data_pagamento->format('Y-m-d')) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            @error('data_pagamento')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="debito" class="block text-sm font-medium text-gray-700 mb-2">Débito (€)</label>
                <input type="number" name="debito" id="debito" value="{{ old('debito', $payment->debito) }}" step="0.01" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                @error('debito')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="credito" class="block text-sm font-medium text-gray-700 mb-2">Crédito (€)</label>
                <input type="number" name="credito" id="credito" value="{{ old('credito', $payment->credito) }}" step="0.01" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                @error('credito')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>
        <div class="flex items-center justify-end space-x-3">
            <a href="{{ route('payments.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Cancelar</a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Atualizar</button>
        </div>
    </form>
</div>
@endsection

