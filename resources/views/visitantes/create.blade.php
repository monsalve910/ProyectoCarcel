@extends('layouts.app')
@section('title', 'Nuevo Visitante')

@section('content')
<h1 class="text-2xl font-bold mb-6">Registrar Nuevo Visitante</h1>

<form action="{{ route('visitantes.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow max-w-2xl">
    @csrf

    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-gray-700 font-bold mb-2">Nombre *</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}" class="w-full px-3 py-2 border rounded-lg" required>
        </div>
        <div>
            <label class="block text-gray-700 font-bold mb-2">Apellido *</label>
            <input type="text" name="apellido" value="{{ old('apellido') }}" class="w-full px-3 py-2 border rounded-lg" required>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-gray-700 font-bold mb-2">Número de Identificación *</label>
            <input type="text" name="numero_identificacion" value="{{ old('numero_identificacion') }}" class="w-full px-3 py-2 border rounded-lg" required>
        </div>
        <div>
            <label class="block text-gray-700 font-bold mb-2">Teléfono</label>
            <input type="text" name="telefono" value="{{ old('telefono') }}" class="w-full px-3 py-2 border rounded-lg">
        </div>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Parentesco *</label>
        <select name="parentesco" class="w-full px-3 py-2 border rounded-lg" required>
            <option value="">Seleccione...</option>
            <option value="Familiar">Familiar</option>
            <option value="Abogado">Abogado</option>
            <option value="Amigo">Amigo</option>
            <option value="Otro">Otro</option>
        </select>
    </div>

    <div class="mb-6">
        <label class="block text-gray-700 font-bold mb-2">Dirección</label>
        <textarea name="direccion" rows="2" class="w-full px-3 py-2 border rounded-lg">{{ old('direccion') }}</textarea>
    </div>

    <div class="flex gap-4">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Guardar</button>
        <a href="{{ route('visitantes.index') }}" class="bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500">Cancelar</a>
    </div>
</form>
@endsection
