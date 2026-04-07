@extends('layouts.app')
@section('title', 'Visitantes')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Lista de Visitantes</h1>
    <a href="{{ route('visitantes.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Nuevo Visitante
    </a>
</div>

<form method="GET" class="bg-white p-4 rounded-lg shadow mb-6">
    <div class="flex gap-4 items-end">
        <div class="flex-1">
            <label class="block text-sm text-gray-600 mb-1">Buscar</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nombre, apellido o identificación..."
                class="w-full px-3 py-2 border rounded-lg">
        </div>
        <div>
            <label class="block text-sm text-gray-600 mb-1">Estado</label>
            <select name="estado" class="px-3 py-2 border rounded-lg">
                <option value="">Todos</option>
                <option value="1" {{ request('estado') == '1' ? 'selected' : '' }}>Activos</option>
                <option value="0" {{ request('estado') == '0' ? 'selected' : '' }}>Inactivos</option>
            </select>
        </div>
        <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Filtrar</button>
        <a href="{{ route('visitantes.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Limpiar</a>
    </div>
</form>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left py-3 px-4">Nombre</th>
                <th class="text-left py-3 px-4">Identificación</th>
                <th class="text-left py-3 px-4">Teléfono</th>
                <th class="text-left py-3 px-4">Parentesco</th>
                <th class="text-left py-3 px-4">Estado</th>
                <th class="text-left py-3 px-4">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($visitantes as $visitante)
            <tr class="border-b hover:bg-gray-50">
                <td class="py-3 px-4">{{ $visitante->nombre_completo }}</td>
                <td class="py-3 px-4">{{ $visitante->numero_identificacion }}</td>
                <td class="py-3 px-4">{{ $visitante->telefono ?? 'N/A' }}</td>
                <td class="py-3 px-4">{{ $visitante->parentesco }}</td>
                <td class="py-3 px-4">
                    @if($visitante->estado)
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Activo</span>
                    @else
                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">Inactivo</span>
                    @endif
                </td>
                <td class="py-3 px-4">
                    <a href="{{ route('visitantes.show', $visitante) }}" class="text-blue-600 hover:underline mr-2">Ver</a>
                    <a href="{{ route('visitantes.edit', $visitante) }}" class="text-green-600 hover:underline mr-2">Editar</a>
                    <form action="{{ route('visitantes.destroy', $visitante) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('¿Está seguro?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="py-8 text-center text-gray-500">No hay visitantes registrados</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $visitantes->withQueryString()->links() }}</div>
@endsection
