@extends('layouts.app')
@section('title', 'Reporte de Visitas')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Reporte de Visitas</h1>
    <div class="flex gap-2">
        <a href="{{ route('reportes.visitas.pdf', request()->query()) }}" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">PDF</a>
        <a href="{{ route('reportes.visitas.excel', request()->query()) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Excel</a>
    </div>
</div>

<form method="GET" class="bg-white p-4 rounded-lg shadow mb-6">
    <div class="flex flex-wrap gap-4 items-end">
        <div>
            <label class="block text-sm text-gray-600 mb-1">Estado</label>
            <select name="estado" class="px-3 py-2 border rounded-lg">
                <option value="">Todos</option>
                <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="aprobada" {{ request('estado') == 'aprobada' ? 'selected' : '' }}>Aprobada</option>
                <option value="completada" {{ request('estado') == 'completada' ? 'selected' : '' }}>Completada</option>
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
        <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Filtrar</button>
        <a href="{{ route('reportes.visitas') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Limpiar</a>
    </div>
</form>

@if(isset($stats))
<div class="grid grid-cols-4 gap-4 mb-6">
    <div class="bg-yellow-100 p-4 rounded-lg"><strong>Pendientes:</strong> {{ $stats['pendientes'] }}</div>
    <div class="bg-blue-100 p-4 rounded-lg"><strong>Aprobadas:</strong> {{ $stats['aprobadas'] }}</div>
    <div class="bg-green-100 p-4 rounded-lg"><strong>Completadas:</strong> {{ $stats['completadas'] }}</div>
    <div class="bg-red-100 p-4 rounded-lg"><strong>Rechazadas:</strong> {{ $stats['rechazadas'] }}</div>
</div>
@endif

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left py-3 px-4">Fecha/Hora</th>
                <th class="text-left py-3 px-4">Prisionero</th>
                <th class="text-left py-3 px-4">Visitante</th>
                <th class="text-left py-3 px-4">Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($datos as $visita)
            <tr class="border-b">
                <td class="py-3 px-4">{{ $visita->fecha_hora_entrada->format('d/m/Y H:i') }}</td>
                <td class="py-3 px-4">{{ $visita->prisionero->nombre_completo ?? 'N/A' }}</td>
                <td class="py-3 px-4">{{ $visita->visitante->nombre_completo ?? 'N/A' }}</td>
                <td class="py-3 px-4">{{ ucfirst($visita->estado) }}</td>
            </tr>
            @empty
            <tr><td colspan="4" class="py-8 text-center text-gray-500">No hay datos</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4 text-gray-600">
    <p><strong>Total:</strong> {{ $total }} visitas</p>
    <p><strong>Generado:</strong> {{ $fecha_generacion }}</p>
</div>
@endsection
