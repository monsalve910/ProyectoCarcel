@extends('layouts.app')
@section('title', 'Ver Prisionero')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Detalle del Prisionero</h1>
    <a href="{{ route('prisioneros.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
        Volver
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4 border-b pb-2">Información Personal</h2>
        <dl class="space-y-3">
            <div class="flex">
                <dt class="w-40 font-bold text-gray-600">Número de Celda:</dt>
                <dd>{{ $prisionero->numero_celda }}</dd>
            </div>
            <div class="flex">
                <dt class="w-40 font-bold text-gray-600">Nombre:</dt>
                <dd>{{ $prisionero->nombre_completo }}</dd>
            </div>
            <div class="flex">
                <dt class="w-40 font-bold text-gray-600">Identificación:</dt>
                <dd>{{ $prisionero->numero_identificacion }}</dd>
            </div>
            <div class="flex">
                <dt class="w-40 font-bold text-gray-600">Fecha de Nac.:</dt>
                <dd>{{ $prisionero->fecha_nacimiento->format('d/m/Y') }}</dd>
            </div>
            <div class="flex">
                <dt class="w-40 font-bold text-gray-600">Fecha de Ingreso:</dt>
                <dd>{{ $prisionero->fecha_ingreso->format('d/m/Y') }}</dd>
            </div>
            <div class="flex">
                <dt class="w-40 font-bold text-gray-600">Salida Prevista:</dt>
                <dd>{{ $prisionero->fecha_salida_prevista?->format('d/m/Y') ?? 'No definida' }}</dd>
            </div>
            <div class="flex">
                <dt class="w-40 font-bold text-gray-600">Delito:</dt>
                <dd>{{ $prisionero->delito }}</dd>
            </div>
            <div class="flex">
                <dt class="w-40 font-bold text-gray-600">Estado:</dt>
                <dd>
                    @if($prisionero->estado)
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Activo</span>
                    @else
                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">Inactivo</span>
                    @endif
                </dd>
            </div>
        </dl>

        <div class="mt-6 flex gap-4">
            <a href="{{ route('prisioneros.edit', $prisionero) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Editar
            </a>
            <form action="{{ route('prisioneros.destroy', $prisionero) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700" onclick="return confirm('¿Está seguro?')">
                    Eliminar
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4 border-b pb-2">Visitas Recientes</h2>
        <table class="w-full">
            <thead>
                <tr class="border-b">
                    <th class="text-left py-2">Visitante</th>
                    <th class="text-left py-2">Fecha</th>
                    <th class="text-left py-2">Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prisionero->visitas as $visita)
                <tr class="border-b">
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
                    <td colspan="3" class="py-4 text-center text-gray-500">No hay visitas registradas</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
