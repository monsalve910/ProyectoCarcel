@extends('layouts.app')
@section('title', 'Visitas')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Lista de Visitas</h1>
    <a href="{{ route('visitas.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Nueva Visita</a>
</div>

<form method="GET" class="bg-white p-4 rounded-lg shadow mb-6">
    <div class="flex flex-wrap gap-4 items-end">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm text-gray-600 mb-1">Buscar</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Prisionero o visitante..." class="w-full px-3 py-2 border rounded-lg">
        </div>
        <div>
            <label class="block text-sm text-gray-600 mb-1">Estado</label>
            <select name="estado" class="px-3 py-2 border rounded-lg">
                <option value="">Todos</option>
                <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="aprobada" {{ request('estado') == 'aprobada' ? 'selected' : '' }}>Aprobada</option>
                <option value="completada" {{ request('estado') == 'completada' ? 'selected' : '' }}>Completada</option>
                <option value="rechazada" {{ request('estado') == 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                <option value="cancelada" {{ request('estado') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
            </select>
        </div>
        <div>
            <label class="block text-sm text-gray-600 mb-1">Desde</label>
            <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}" class="px-3 py-2 border rounded-lg">
        </div>
        <div>
            <label class="block text-sm text-gray-600 mb-1">Hasta</label>
            <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}" class="px-3 py-2 border rounded-lg">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Filtrar</button>
            <a href="{{ route('visitas.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Limpiar</a>
        </div>
    </div>
</form>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left py-3 px-4">Prisionero</th>
                <th class="text-left py-3 px-4">Visitante</th>
                <th class="text-left py-3 px-4">Fecha/Hora</th>
                <th class="text-left py-3 px-4">Guardia</th>
                <th class="text-left py-3 px-4">Estado</th>
                <th class="text-left py-3 px-4">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($visitas as $visita)
            <tr class="border-b hover:bg-gray-50">
                <td class="py-3 px-4">{{ $visita->prisionero->nombre_completo ?? 'N/A' }}</td>
                <td class="py-3 px-4">{{ $visita->visitante->nombre_completo ?? 'N/A' }}</td>
                <td class="py-3 px-4">{{ $visita->fecha_hora_entrada->format('d/m/Y H:i') }}</td>
                <td class="py-3 px-4">{{ $visita->guardia->name ?? 'N/A' }}</td>
                <td class="py-3 px-4">
                    <span class="px-2 py-1 rounded text-xs 
                        @if($visita->estado === 'pendiente') bg-yellow-100 text-yellow-800
                        @elseif($visita->estado === 'aprobada') bg-blue-100 text-blue-800
                        @elseif($visita->estado === 'completada') bg-green-100 text-green-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst($visita->estado) }}
                    </span>
                </td>
                <td class="py-3 px-4">
                    <a href="{{ route('visitas.show', $visita) }}" class="text-blue-600 hover:underline mr-2">Ver</a>
                    @if($visita->estado === 'pendiente')
                        <form action="{{ route('visitas.approve', $visita) }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="text-green-600 hover:underline mr-2">Aprobar</button>
                        </form>
                        <form action="{{ route('visitas.reject', $visita) }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="text-red-600 hover:underline">Rechazar</button>
                        </form>
                    @elseif($visita->estado === 'aprobada')
                        <form action="{{ route('visitas.complete', $visita) }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="text-green-600 hover:underline">Completar</button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="py-8 text-center text-gray-500">No hay visitas registradas</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $visitas->withQueryString()->links() }}</div>
@endsection
