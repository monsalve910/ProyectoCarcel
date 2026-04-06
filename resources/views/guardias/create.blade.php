@extends('layouts.app')
@section('title', 'Nuevo Guardia')

@section('content')
<h1 class="text-2xl font-bold mb-6">Registrar Nuevo Guardia</h1>

<form action="{{ route('guardias.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow max-w-2xl">
    @csrf

    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Nombre Completo *</label>
        <input type="text" name="name" value="{{ old('name') }}" class="w-full px-3 py-2 border rounded-lg" required>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Correo Electrónico *</label>
        <input type="email" name="email" value="{{ old('email') }}" class="w-full px-3 py-2 border rounded-lg" required>
    </div>

    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-gray-700 font-bold mb-2">Contraseña *</label>
            <input type="password" name="password" class="w-full px-3 py-2 border rounded-lg" required>
        </div>
        <div>
            <label class="block text-gray-700 font-bold mb-2">Confirmar Contraseña *</label>
            <input type="password" name="password_confirmation" class="w-full px-3 py-2 border rounded-lg" required>
        </div>
    </div>

    <div class="flex gap-4">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Guardar</button>
        <a href="{{ route('guardias.index') }}" class="bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500">Cancelar</a>
    </div>
</form>
@endsection
