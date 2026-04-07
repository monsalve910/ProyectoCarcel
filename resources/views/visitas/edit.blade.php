@extends('layouts.app')
@section('title', 'Editar Visita')

@section('content')
<h1 class="text-2xl font-bold mb-6">Editar Visita</h1>

<div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-6">
    <p><strong>Nota:</strong> Las visitas solo pueden programarse los días <strong>domingo</strong> entre las <strong>14:00</strong> y <strong>17:00</strong> horas.</p>
</div>

<form action="{{ route('visitas.update', $visita) }}" method="POST" class="bg-white p-6 rounded-lg shadow max-w-2xl">
    @csrf @method('PUT')

    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Prisionero *</label>
        <select name="prisionero_id" class="w-full px-3 py-2 border rounded-lg" required>
            @foreach($prisioneros as $prisionero)
            <option value="{{ $prisionero->id }}" {{ $visita->prisionero_id == $prisionero->id ? 'selected' : '' }}>
                {{ $prisionero->numero_celda }} - {{ $prisionero->nombre_completo }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Visitante *</label>
        <select name="visitante_id" class="w-full px-3 py-2 border rounded-lg" required>
            @foreach($visitantes as $visitante)
            <option value="{{ $visitante->id }}" {{ $visita->visitante_id == $visitante->id ? 'selected' : '' }}>
                {{ $visitante->nombre_completo }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-gray-700 font-bold mb-2">Fecha y Hora de Entrada *</label>
            <input type="datetime-local" name="fecha_hora_entrada" value="{{ old('fecha_hora_entrada', $visita->fecha_hora_entrada->format('Y-m-d\TH:i')) }}" class="w-full px-3 py-2 border rounded-lg" required>
        </div>
        <div>
            <label class="block text-gray-700 font-bold mb-2">Fecha y Hora de Salida *</label>
            <input type="datetime-local" name="fecha_hora_salida" value="{{ old('fecha_hora_salida', $visita->fecha_hora_salida->format('Y-m-d\TH:i')) }}" class="w-full px-3 py-2 border rounded-lg" required>
        </div>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Estado</label>
        <select name="estado" class="w-full px-3 py-2 border rounded-lg">
            <option value="pendiente" {{ $visita->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
            <option value="aprobada" {{ $visita->estado === 'aprobada' ? 'selected' : '' }}>Aprobada</option>
            <option value="rechazada" {{ $visita->estado === 'rechazada' ? 'selected' : '' }}>Rechazada</option>
            <option value="completada" {{ $visita->estado === 'completada' ? 'selected' : '' }}>Completada</option>
            <option value="cancelada" {{ $visita->estado === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
        </select>
    </div>

    <div class="mb-6">
        <label class="block text-gray-700 font-bold mb-2">Observaciones</label>
        <textarea name="observaciones" rows="3" class="w-full px-3 py-2 border rounded-lg">{{ old('observaciones', $visita->observaciones) }}</textarea>
    </div>

    <div class="flex gap-4">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Actualizar</button>
        <a href="{{ route('visitas.index') }}" class="bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500">Cancelar</a>
    </div>
</form>
@endsection
