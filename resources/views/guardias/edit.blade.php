@extends('layouts.app')
@section('title', 'Editar Guardia')

@section('content')
<h1 class="text-2xl font-bold mb-6">Editar Guardia</h1>

<form action="{{ route('guardias.update', $guardia) }}" method="POST" class="bg-white p-6 rounded-lg shadow max-w-2xl">
    @csrf @method('PUT')

    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Nombre Completo *</label>
        <input type="text" name="name" value="{{ old('name', $guardia->name) }}" class="w-full px-3 py-2 border rounded-lg" required>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Correo Electrónico *</label>
        <input type="email" name="email" value="{{ old('email', $guardia->email) }}" class="w-full px-3 py-2 border rounded-lg" required>
    </div>

    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-gray-700 font-bold mb-2">Nueva Contraseña</label>
            <input type="password" name="password" class="w-full px-3 py-2 border rounded-lg" placeholder="Dejar en blanco para no cambiar">
        </div>
        <div>
            <label class="block text-gray-700 font-bold mb-2">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" class="w-full px-3 py-2 border rounded-lg">
        </div>
    </div>

    <div class="mb-6">
        <label class="flex items-center">
            <input type="checkbox" name="is_active" value="1" {{ $guardia->is_active ? 'checked' : '' }} class="mr-2">
            <span class="text-gray-700">Guardia Activo</span>
        </label>
    </div>

    <div class="flex gap-4">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Actualizar</button>
        <a href="{{ route('guardias.index') }}" class="bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500">Cancelar</a>
    </div>
</form>
@endsection
