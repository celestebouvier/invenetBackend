<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Orden de Reparación</title>
    <style>
    body { font-family: DejaVu Sans, sans-serif; margin: 40px; color: #333; }
    h1 { text-align: center; color: #1a202c; }
    p { margin: 5px 0; }
    .section { margin-top: 20px; }
    .footer { margin-top: 40px; font-size: 12px; text-align: center; color: #777; }
    </style>
</head>
<body>
    <h1>Orden de Reparación #{{ $orden->id }}</h1>
    <p><strong>Reporte:</strong> {{ $orden->reporte->descripcion }}</p>
    <p><strong>Técnico asignado:</strong> {{ $orden->tecnico->name }}</p>
    <p><strong>Detalles:</strong> {{ $orden->descripcion }}</p>
    <p><strong>Fecha:</strong> {{ $orden->created_at->format('d/m/Y') }}</p>
    <p><strong>Completada:</strong> {{ $orden->completada ? 'Sí' : 'No' }}</p>
@if ($orden->estado === 'completada')
    <p><strong>Detalles finales del técnico:</strong> {{ $orden->descripcion }}</p>
@endif
</body>
</html>
