@extends('layouts.app')
@section('title', 'Reportes')

@section('content')
<h1 class="text-2xl font-bold mb-6">Sistema de Reportes</h1>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <a href="{{ route('reportes.prisioneros') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
        <h2 class="text-xl font-bold mb-2 text-blue-600">Reporte de Prisioneros</h2>
        <p class="text-gray-600">Lista completa de prisioneros registrados en el sistema.</p>
    </a>

    <a href="{{ route('reportes.visitantes') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
        <h2 class="text-xl font-bold mb-2 text-green-600">Reporte de Visitantes</h2>
        <p class="text-gray-600">Lista completa de visitantes registrados.</p>
    </a>

    <a href="{{ route('reportes.visitas') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
        <h2 class="text-xl font-bold mb-2 text-purple-600">Reporte de Visitas</h2>
        <p class="text-gray-600">Historial completo de visitas realizadas.</p>
    </a>

    <a href="{{ route('reportes.auditoria') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
        <h2 class="text-xl font-bold mb-2 text-red-600">Reporte de Auditoría</h2>
        <p class="text-gray-600">Registro de accesos al sistema.</p>
    </a>
</div>
@endsection
