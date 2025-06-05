<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Orden de Reparación</title>
    <style> body { font-family: DejaVu Sans; } </style>
</head>
<body>
    <h1>Orden de Reparación #{{ $orden->id }}</h1>
    <p><strong>Reporte:</strong> {{ $orden->reporte->descripcion }}</p>
    <p><strong>Técnico asignado:</strong> {{ $orden->tecnico->name }}</p>
    <p><strong>Detalles:</strong> {{ $orden->detalles }}</p>
    <p><strong>Fecha:</strong> {{ $orden->created_at->format('d/m/Y') }}</p>
    <p><strong>Completada:</strong> {{ $orden->completada ? 'Sí' : 'No' }}</p>
@if ($orden->completada)
    <p><strong>Detalles finales del técnico:</strong> {{ $orden->detalles }}</p>
@endif
</body>
</html>
