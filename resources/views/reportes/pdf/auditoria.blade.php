<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $titulo }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 20px; }
        h1 { font-size: 18px; text-align: center; margin-bottom: 5px; }
        .subtitle { text-align: center; color: #666; font-size: 10px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #e74c3c; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .footer { margin-top: 20px; text-align: right; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <h1>{{ $titulo }}</h1>
    <p class="subtitle">Generado: {{ $fecha_generacion }}</p>
    @if($fecha_desde || $fecha_hasta)
    <p class="subtitle">Período: {{ $fecha_desde ? "Desde {$fecha_desde}" : '' }} {{ $fecha_hasta ? "Hasta {$fecha_hasta}" : '' }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Fecha/Hora Login</th>
                <th>Fecha/Hora Logout</th>
                <th>IP</th>
                <th>Exitoso</th>
            </tr>
        </thead>
        <tbody>
            @foreach($datos as $log)
            <tr>
                <td>{{ $log->user->name ?? 'N/A' }}</td>
                <td>{{ $log->login_at->format('d/m/Y H:i:s') }}</td>
                <td>{{ $log->logout_at?->format('d/m/Y H:i:s') ?? 'En sesión' }}</td>
                <td>{{ $log->ip_address ?? 'N/A' }}</td>
                <td>{{ $log->successful ? 'Sí' : 'No' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p class="footer">Total: {{ $total }} registros</p>
</body>
</html>
