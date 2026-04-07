@extends('layouts.app')
@section('title', 'Reporte de Visitantes')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Reporte de Visitantes</h1>
    <div class="flex gap-2">
        <a href="{{ route('reportes.visitantes.pdf', request()->query()) }}" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">PDF</a>
        <a href="{{ route('reportes.visitantes.excel', request()->query()) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Excel</a>
    </div>
</div>

<form method="GET" class="bg-white p-4 rounded-lg shadow mb-6">
    <div class="flex gap-4 items-end">
        <div>
            <label class="block text-sm text-gray-600 mb-1">Desde</label>
            <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}" class="px-3 py-2 border rounded-lg">
        </div>
        <div>
            <label class="block text-sm text-gray-600 mb-1">Hasta</label>
            <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}" class="px-3 py-2 border rounded-lg">
        </div>
        <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Filtrar</button>
        <a href="{{ route('reportes.visitantes') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Limpiar</a>
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
            </tr>
        </thead>
        <tbody>
            @forelse($datos as $visitante)
            <tr class="border-b">
                <td class="py-3 px-4">{{ $visitante->nombre_completo }}</td>
                <td class="py-3 px-4">{{ $visitante->numero_identificacion }}</td>
                <td class="py-3 px-4">{{ $visitante->telefono ?? 'N/A' }}</td>
                <td class="py-3 px-4">{{ $visitante->parentesco }}</td>
                <td class="py-3 px-4">{{ $visitante->estado ? 'Activo' : 'Inactivo' }}</td>
            </tr>
            @empty
            <tr><td colspan="5" class="py-8 text-center text-gray-500">No hay datos</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4 text-gray-600">
    <p><strong>Total:</strong> {{ $total }} visitantes</p>
    <p><strong>Generado:</strong> {{ $fecha_generacion }}</p>
</div>
@endsection
