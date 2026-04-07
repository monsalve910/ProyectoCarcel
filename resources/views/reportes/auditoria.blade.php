@extends('layouts.app')
@section('title', 'Reporte de Auditoría')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Reporte de Auditoría de Accesos</h1>
    <div class="flex gap-2">
        <a href="{{ route('reportes.auditoria.pdf', request()->query()) }}" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">PDF</a>
        <a href="{{ route('reportes.auditoria.excel', request()->query()) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Excel</a>
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
        <a href="{{ route('reportes.auditoria') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Limpiar</a>
    </div>
</form>

@if(isset($stats))
<div class="grid grid-cols-2 gap-4 mb-6">
    <div class="bg-green-100 p-4 rounded-lg"><strong>Accesos Exitosos:</strong> {{ $stats['exitosos'] }}</div>
    <div class="bg-red-100 p-4 rounded-lg"><strong>Accesos Fallidos:</strong> {{ $stats['fallidos'] }}</div>
</div>
@endif

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left py-3 px-4">Usuario</th>
                <th class="text-left py-3 px-4">Fecha/Hora Login</th>
                <th class="text-left py-3 px-4">Fecha/Hora Logout</th>
                <th class="text-left py-3 px-4">IP</th>
                <th class="text-left py-3 px-4">Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($datos as $log)
            <tr class="border-b">
                <td class="py-3 px-4">{{ $log->user->name ?? 'N/A' }}</td>
                <td class="py-3 px-4">{{ $log->login_at->format('d/m/Y H:i:s') }}</td>
                <td class="py-3 px-4">{{ $log->logout_at?->format('d/m/Y H:i:s') ?? 'En sesión' }}</td>
                <td class="py-3 px-4">{{ $log->ip_address ?? 'N/A' }}</td>
                <td class="py-3 px-4">@if($log->successful)<span class="text-green-600">Exitoso</span>@else<span class="text-red-600">Fallido</span>@endif</td>
            </tr>
            @empty
            <tr><td colspan="5" class="py-8 text-center text-gray-500">No hay datos</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4 text-gray-600">
    <p><strong>Total:</strong> {{ $total }} registros</p>
    <p><strong>Generado:</strong> {{ $fecha_generacion }}</p>
</div>
@endsection
