@extends('layouts.app')
@section('title', 'Ver Visita')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Detalle de la Visita</h1>
    <a href="{{ route('visitas.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Volver</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4 border-b pb-2">Información de la Visita</h2>
        <dl class="space-y-3">
            <div class="flex"><dt class="w-40 font-bold text-gray-600">Prisionero:</dt><dd>{{ $visita->prisionero->nombre_completo ?? 'N/A' }} ({{ $visita->prisionero->numero_celda ?? 'N/A' }})</dd></div>
            <div class="flex"><dt class="w-40 font-bold text-gray-600">Visitante:</dt><dd>{{ $visita->visitante->nombre_completo ?? 'N/A' }}</dd></div>
            <div class="flex"><dt class="w-40 font-bold text-gray-600">Guardia:</dt><dd>{{ $visita->guardia->name ?? 'N/A' }}</dd></div>
            <div class="flex"><dt class="w-40 font-bold text-gray-600">Entrada:</dt><dd>{{ $visita->fecha_hora_entrada->format('d/m/Y H:i') }}</dd></div>
            <div class="flex"><dt class="w-40 font-bold text-gray-600">Salida:</dt><dd>{{ $visita->fecha_hora_salida->format('d/m/Y H:i') }}</dd></div>
            <div class="flex">
                <dt class="w-40 font-bold text-gray-600">Estado:</dt>
                <dd>
                    <span class="px-2 py-1 rounded text-xs 
                        @if($visita->estado === 'pendiente') bg-yellow-100 text-yellow-800
                        @elseif($visita->estado === 'aprobada') bg-blue-100 text-blue-800
                        @elseif($visita->estado === 'completada') bg-green-100 text-green-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst($visita->estado) }}
                    </span>
                </dd>
            </div>
            <div class="flex"><dt class="w-40 font-bold text-gray-600">Observaciones:</dt><dd>{{ $visita->observaciones ?? 'Sin observaciones' }}</dd></div>
        </dl>

        <div class="mt-6 flex gap-4">
            @if($visita->estado === 'pendiente')
                <form action="{{ route('visitas.approve', $visita) }}" method="POST" class="inline">
                    @csrf @method('PATCH')
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Aprobar</button>
                </form>
                <form action="{{ route('visitas.reject', $visita) }}" method="POST" class="inline">
                    @csrf @method('PATCH')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Rechazar</button>
                </form>
            @elseif($visita->estado === 'aprobada')
                <form action="{{ route('visitas.complete', $visita) }}" method="POST" class="inline">
                    @csrf @method('PATCH')
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Completar</button>
                </form>
            @endif
            @if(!in_array($visita->estado, ['completada', 'cancelada']))
                <form action="{{ route('visitas.cancel', $visita) }}" method="POST" class="inline">
                    @csrf @method('PATCH')
                    <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Cancelar</button>
                </form>
            @endif
            <a href="{{ route('visitas.edit', $visita) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Editar</a>
        </div>
    </div>
</div>
@endsection
