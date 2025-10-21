<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Etiqueta QR</title>
    <style>
        body {
            font-family: sans-serif;
            text-align: center;
            margin: 40px;
        }
        .qr {
            margin-top: 20px;
        }
        .info {
            margin-top: 20px;
        }
        .btn {
            display: inline-block;
            margin-top: 30px;
            padding: 10px 20px;
            background-color: black;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }
        .btn:hover {
            background-color: #333;
        }
    </style>
</head>
<body>
    <h2>Etiqueta QR de Dispositivo</h2>
{{-- (PNG con Base64, más compatible con Dompdf) --}}
    <div class="qr">
        {!! QrCode::format('svg')->size(200)->generate($dispositivo->id) !!}
    </div>
    <div class="info">
        <p><strong>Dispositivo:</strong> {{ $dispositivo->tipo }}</p>
        <p><strong>ID:</strong> {{ $dispositivo->id }}</p>
        <p><strong>Código QR:</strong> {{ $dispositivo->id }}</p>
    </div>

</html>
