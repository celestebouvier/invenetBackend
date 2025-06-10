<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Etiqueta QR</title>
    <style>
        body { font-family: sans-serif; text-align: center; }
        .info { margin-top: 20px; }
    </style>
</head>
<body>
    <h2>Etiqueta QR de Dispositivo</h2>

    <div class="qr">
        {!! QrCode::format('svg')->size(200)->generate($dispositivo->id) !!}
    </div>
    <div class="info">
        <p><strong>Dispositivo:</strong> {{ $dispositivo->tipo }}</p>
        <p><strong>ID:</strong> {{ $dispositivo->id }}</p>
        <p><strong>Código QR:</strong> {{ $dispositivo->id }}</p>
    </div>
</body>
</html>
