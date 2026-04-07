@extends('layouts.app')
@section('title', 'Dashboard - Administrador')

@section('content')
<h1 class="text-3xl font-bold mb-8">Panel de Administración</h1>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-500 text-sm">Total Prisioneros</h3>
        <p class="text-3xl font-bold">{{ $stats['total_prisioneros'] }}</p>
        <p class="text-green-600 text-sm">{{ $stats['prisioneros_activos'] }} activos</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-500 text-sm">Total Visitantes</h3>
        <p class="text-3xl font-bold">{{ $stats['total_visitantes'] }}</p>
        <p class="text-green-600 text-sm">{{ $stats['visitantes_activos'] }} activos</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-500 text-sm">Total Guardias</h3>
        <p class="text-3xl font-bold">{{ $stats['total_guardias'] }}</p>
        <p class="text-green-600 text-sm">{{ $stats['guardias_activos'] }} activos</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-500 text-sm">Visitas Pendientes</h3>
        <p class="text-3xl font-bold">{{ $stats['visitas_pendientes'] }}</p>
        <p class="text-blue-600 text-sm">{{ $stats['visitas_hoy'] }} hoy</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Visitas Recientes</h2>
        <table class="w-full">
            <thead>
                <tr class="border-b">
                    <th class="text-left py-2">Prisionero</th>
                    <th class="text-left py-2">Visitante</th>
                    <th class="text-left py-2">Fecha</th>
                    <th class="text-left py-2">Estado</th>
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
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-4 text-center text-gray-500">No hay visitas registradas</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Accesos Recientes</h2>
        <table class="w-full">
            <thead>
                <tr class="border-b">
                    <th class="text-left py-2">Usuario</th>
                    <th class="text-left py-2">Fecha/Hora</th>
                    <th class="text-left py-2">IP</th>
                    <th class="text-left py-2">Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentLogins as $log)
                <tr class="border-b">
                    <td class="py-2">{{ $log->user->name ?? 'N/A' }}</td>
                    <td class="py-2">{{ $log->login_at->format('d/m/Y H:i') }}</td>
                    <td class="py-2">{{ $log->ip_address ?? 'N/A' }}</td>
                    <td class="py-2">
                        @if($log->successful)
                            <span class="text-green-600">Exitoso</span>
                        @else
                            <span class="text-red-600">Fallido</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-4 text-center text-gray-500">No hay accesos registrados</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
