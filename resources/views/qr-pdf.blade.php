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
    <div>{!! QrCode::size(200)->generate($codigo_qr) !!}</div>
    <div class="info">
        <p><strong>ID:</strong> {{ $id }}</p>
        <p><strong>Código QR:</strong> {{ $codigo_qr }}</p>
    </div>
</body>
</html>
