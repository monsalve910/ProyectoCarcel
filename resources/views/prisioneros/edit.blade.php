@extends('layouts.app')
@section('title', 'Editar Prisionero')

@section('content')
<h1 class="text-2xl font-bold mb-6">Editar Prisionero</h1>

<form action="{{ route('prisioneros.update', $prisionero) }}" method="POST" class="bg-white p-6 rounded-lg shadow max-w-2xl">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-gray-700 font-bold mb-2">Número de Celda *</label>
            <input type="text" name="numero_celda" value="{{ old('numero_celda', $prisionero->numero_celda) }}"
                class="w-full px-3 py-2 border rounded-lg @error('numero_celda') border-red-500 @enderror" required>
            @error('numero_celda')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block text-gray-700 font-bold mb-2">Número de Identificación *</label>
            <input type="text" name="numero_identificacion" value="{{ old('numero_identificacion', $prisionero->numero_identificacion) }}"
                class="w-full px-3 py-2 border rounded-lg @error('numero_identificacion') border-red-500 @enderror" required>
            @error('numero_identificacion')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-gray-700 font-bold mb-2">Nombre *</label>
            <input type="text" name="nombre" value="{{ old('nombre', $prisionero->nombre) }}"
                class="w-full px-3 py-2 border rounded-lg @error('nombre') border-red-500 @enderror" required>
            @error('nombre')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block text-gray-700 font-bold mb-2">Apellido *</label>
            <input type="text" name="apellido" value="{{ old('apellido', $prisionero->apellido) }}"
                class="w-full px-3 py-2 border rounded-lg @error('apellido') border-red-500 @enderror" required>
            @error('apellido')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-gray-700 font-bold mb-2">Fecha de Nacimiento *</label>
            <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $prisionero->fecha_nacimiento->format('Y-m-d')) }}"
                class="w-full px-3 py-2 border rounded-lg @error('fecha_nacimiento') border-red-500 @enderror" required>
            @error('fecha_nacimiento')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block text-gray-700 font-bold mb-2">Fecha de Ingreso *</label>
            <input type="date" name="fecha_ingreso" value="{{ old('fecha_ingreso', $prisionero->fecha_ingreso->format('Y-m-d')) }}"
                class="w-full px-3 py-2 border rounded-lg @error('fecha_ingreso') border-red-500 @enderror" required>
            @error('fecha_ingreso')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Fecha de Salida Prevista</label>
        <input type="date" name="fecha_salida_prevista" value="{{ old('fecha_salida_prevista', $prisionero->fecha_salida_prevista?->format('Y-m-d')) }}"
            class="w-full px-3 py-2 border rounded-lg @error('fecha_salida_prevista') border-red-500 @enderror">
        @error('fecha_salida_prevista')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Delito *</label>
        <textarea name="delito" rows="3"
            class="w-full px-3 py-2 border rounded-lg @error('delito') border-red-500 @enderror" required>{{ old('delito', $prisionero->delito) }}</textarea>
        @error('delito')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-6">
        <label class="flex items-center">
            <input type="checkbox" name="estado" value="1" {{ $prisionero->estado ? 'checked' : '' }} class="mr-2">
            <span class="text-gray-700">Prisionero Activo</span>
        </label>
    </div>

    <div class="flex gap-4">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
            Actualizar
        </button>
        <a href="{{ route('prisioneros.index') }}" class="bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500">
            Cancelar
        </a>
    </div>
</form>
@endsection
