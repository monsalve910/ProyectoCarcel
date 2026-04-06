@extends('layouts.app')
@section('title', 'Ver Guardia')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Detalle del Guardia</h1>
    <a href="{{ route('guardias.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Volver</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4 border-b pb-2">Información</h2>
        <dl class="space-y-3">
            <div class="flex"><dt class="w-32 font-bold text-gray-600">Nombre:</dt><dd>{{ $guardia->name }}</dd></div>
            <div class="flex"><dt class="w-32 font-bold text-gray-600">Email:</dt><dd>{{ $guardia->email }}</dd></div>
            <div class="flex"><dt class="w-32 font-bold text-gray-600">Rol:</dt><dd>Guardia</dd></div>
            <div class="flex">
                <dt class="w-32 font-bold text-gray-600">Estado:</dt>
                <dd>
                    @if($guardia->is_active)
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Activo</span>
                    @else
                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">Inactivo</span>
                    @endif
                </dd>
            </div>
            <div class="flex"><dt class="w-32 font-bold text-gray-600">Total Visitas:</dt><dd>{{ $guardia->visitas()->count() }}</dd></div>
        </dl>

        <div class="mt-6 flex gap-4">
            <a href="{{ route('guardias.edit', $guardia) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Editar</a>
            <form action="{{ route('guardias.toggle-active', $guardia) }}" method="POST" class="inline">
                @csrf @method('PATCH')
                <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">
                    {{ $guardia->is_active ? 'Desactivar' : 'Activar' }}
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4 border-b pb-2">Accesos Recientes</h2>
        <table class="w-full">
            <thead><tr><th class="text-left py-2">Fecha/Hora</th><th class="text-left py-2">IP</th><th class="text-left py-2">Estado</th></tr></thead>
            <tbody>
                @forelse($guardia->loginLogs->take(5) as $log)
                <tr class="border-b">
                    <td class="py-2">{{ $log->login_at->format('d/m/Y H:i') }}</td>
                    <td class="py-2">{{ $log->ip_address ?? 'N/A' }}</td>
                    <td class="py-2">@if($log->successful)<span class="text-green-600">Exitoso</span>@else<span class="text-red-600">Fallido</span>@endif</td>
                </tr>
                @empty
                <tr><td colspan="3" class="py-4 text-center text-gray-500">No hay accesos registrados</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
