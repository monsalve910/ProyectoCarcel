@extends('layouts.app')
@section('title', 'Dashboard - Guardia')

@section('content')
<h1 class="text-3xl font-bold mb-8">Panel de Guardia</h1>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-500 text-sm">Visitas de Hoy</h3>
        <p class="text-3xl font-bold">{{ $stats['visitas_hoy'] }}</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-500 text-sm">Mis Visitas Hoy</h3>
        <p class="text-3xl font-bold">{{ $stats['mis_visitas_hoy'] }}</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-500 text-sm">Visitas Pendientes</h3>
        <p class="text-3xl font-bold">{{ $stats['visitas_pendientes'] }}</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-500 text-sm">Visitas de la Semana</h3>
        <p class="text-3xl font-bold">{{ $stats['visitas_semana'] }}</p>
    </div>
</div>

<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-bold mb-4">Mis Visitas Recientes</h2>
    <table class="w-full">
        <thead>
            <tr class="border-b">
                <th class="text-left py-2">Prisionero</th>
                <th class="text-left py-2">Visitante</th>
                <th class="text-left py-2">Fecha/Hora</th>
                <th class="text-left py-2">Estado</th>
                <th class="text-left py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentVisitas as $visita)
            <tr class="border-b">
                <td class="py-2">{{ $visita->prisionero->nombre_completo ?? 'N/A' }}</td>
                <td class="py-2">{{ $visita->visitante->nombre_completo ?? 'N/A' }}</td>
                <td class="py-2">{{ $visita->fecha_hora_entrada->format('d/m/Y H:i') }}</td>
                <td class="py-2">
                    <span class="px-2 py-1 rounded text-xs 
                        @if($visita->estado === 'pendiente') bg-yellow-100 text-yellow-800
                        @elseif($visita->estado === 'aprobada') bg-blue-100 text-blue-800
                        @elseif($visita->estado === 'completada') bg-green-100 text-green-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst($visita->estado) }}
                    </span>
                </td>
                <td class="py-2">
                    <a href="{{ route('visitas.show', $visita) }}" class="text-blue-600 hover:underline">Ver</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="py-4 text-center text-gray-500">No hay visitas registradas</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
