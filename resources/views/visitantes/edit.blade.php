@extends('layouts.app')
@section('title', 'Editar Visitante')

@section('content')
<h1 class="text-2xl font-bold mb-6">Editar Visitante</h1>

<form action="{{ route('visitantes.update', $visitante) }}" method="POST" class="bg-white p-6 rounded-lg shadow max-w-2xl">
    @csrf @method('PUT')

    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-gray-700 font-bold mb-2">Nombre *</label>
            <input type="text" name="nombre" value="{{ old('nombre', $visitante->nombre) }}" class="w-full px-3 py-2 border rounded-lg" required>
        </div>
        <div>
            <label class="block text-gray-700 font-bold mb-2">Apellido *</label>
            <input type="text" name="apellido" value="{{ old('apellido', $visitante->apellido) }}" class="w-full px-3 py-2 border rounded-lg" required>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-gray-700 font-bold mb-2">Número de Identificación *</label>
            <input type="text" name="numero_identificacion" value="{{ old('numero_identificacion', $visitante->numero_identificacion) }}" class="w-full px-3 py-2 border rounded-lg" required>
        </div>
        <div>
            <label class="block text-gray-700 font-bold mb-2">Teléfono</label>
            <input type="text" name="telefono" value="{{ old('telefono', $visitante->telefono) }}" class="w-full px-3 py-2 border rounded-lg">
        </div>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Parentesco *</label>
        <select name="parentesco" class="w-full px-3 py-2 border rounded-lg" required>
            <option value="Familiar" {{ $visitante->parentesco === 'Familiar' ? 'selected' : '' }}>Familiar</option>
            <option value="Abogado" {{ $visitante->parentesco === 'Abogado' ? 'selected' : '' }}>Abogado</option>
            <option value="Amigo" {{ $visitante->parentesco === 'Amigo' ? 'selected' : '' }}>Amigo</option>
            <option value="Otro" {{ $visitante->parentesco === 'Otro' ? 'selected' : '' }}>Otro</option>
        </select>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Dirección</label>
        <textarea name="direccion" rows="2" class="w-full px-3 py-2 border rounded-lg">{{ old('direccion', $visitante->direccion) }}</textarea>
    </div>

    <div class="mb-6">
        <label class="flex items-center">
            <input type="checkbox" name="estado" value="1" {{ $visitante->estado ? 'checked' : '' }} class="mr-2">
            <span class="text-gray-700">Visitante Activo</span>
        </label>
    </div>

    <div class="flex gap-4">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Actualizar</button>
        <a href="{{ route('visitantes.index') }}" class="bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500">Cancelar</a>
    </div>
</form>
@endsection
