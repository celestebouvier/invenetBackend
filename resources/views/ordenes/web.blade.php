<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Orden de Reparación #{{ $orden->id }}</title>

  <style>
    /* Page layout */
    body { font-family: DejaVu Sans, Arial, sans-serif; margin: 0; padding: 0; color: #111; background: #fff; }
    .container { max-width: 900px; margin: 24px auto; padding: 24px; box-shadow: 0 2px 6px rgba(0,0,0,0.08); }
    header { display:flex; align-items:center; gap:16px; margin-bottom:18px; }
    .title { flex:1; text-align:center; }
    .title h1 { margin:0; font-size:20px; color:#0b5b2f; }
    .title p { margin:2px 0 0; color:#333; font-weight:600; }
    .meta { margin-top:8px; display:flex; justify-content:space-between; gap:8px; flex-wrap:wrap; }
    .meta .box { border:1px solid #e5e7eb; padding:8px 12px; border-radius:6px; background:#fbfbfb; min-width:180px; }

    h2.section { border-bottom: 1px dashed #ddd; padding-bottom:8px; margin-top:18px; color:#0b5b2f; }
    table { width:100%; border-collapse:collapse; margin-top:12px; }
    th, td { padding:8px 10px; border-bottom:1px solid #eee; text-align:left; vertical-align:top; }
    .right { text-align:right; }
    .muted { color:#6b6f76; font-size:0.95rem; }

    /* Buttons */
    .actions { margin-top:18px; display:flex; gap:10px; justify-content:center; }
    .btn { padding:10px 16px; border-radius:8px; cursor:pointer; border:none; font-weight:600; }
    .btn-print { background:#08782b; color:#fff; }
    .btn-close { background:#6b7280; color:#fff; }

    /* Print styles */
    @media print {
      .actions { display:none; }
      .container { box-shadow:none; margin:0; padding:0; }
    }
  </style>
</head>
<body>
  <div class="container" id="orden-content">
    <header>
      <div class="title">
        <h1>Escuela Superior de Comercio N° 44 || Gálvez</h1>
        <p class="muted">Orden de reparación #{{ $orden->id }} &nbsp;·&nbsp; Creada: {{ $orden->created_at->format('d/m/Y H:i') }}</p>
      </div>
      <div style="min-width:140px; text-align:right;">
        <div class="muted">Estado</div>
        <div style="font-weight:700; color:{{ $orden->estado === 'completada' ? '#16a34a' : '#b45309' }}">{{ $orden->estado }}</div>
      </div>
    </header>

    <div class="meta">
      <div class="box">
        <div class="muted">Reporte</div>
        <div><strong>#{{ $orden->reporte->id }}</strong> — {{ \Illuminate\Support\Str::limit($orden->reporte->descripcion, 120) }}</div>
      </div>
      <div class="box">
        <div class="muted">Dispositivo</div>
        <div>
          @if($orden->reporte->dispositivo)
            <strong>{{ $orden->reporte->dispositivo->tipo }}</strong><br/>
            {{ $orden->reporte->dispositivo->marca ?? '—' }} - {{ $orden->reporte->dispositivo->modelo ?? '—' }}<br/>
            Ubicación: {{ $orden->reporte->dispositivo->ubicacion ?? '—' }}
          @else
            —
          @endif
        </div>
      </div>
      <div class="box">
        <div class="muted">Técnico asignado</div>
        <div>{{ $orden->tecnico->name ?? '—' }}<br/><span class="muted">{{ $orden->tecnico->email ?? '' }}</span></div>
      </div>
    </div>

    <h2 class="section">Detalles de la orden</h2>
    <table>
      <tbody>
        <tr>
          <th style="width:220px">Descripción completa</th>
          <td>{{ $orden->descripcion ?? '—' }}</td>
        </tr>
        <tr>
          <th>Reporte original</th>
          <td>{{ $orden->reporte->descripcion ?? '—' }}</td>
        </tr>
        <tr>
          <th>Reportado por</th>
          <td>{{ $orden->reporte->usuario->name ?? ($orden->reporte->usuario_email ?? '—') }}</td>
        </tr>
        <tr>
          <th>Fecha reporte</th>
          <td>{{ optional($orden->reporte->created_at)->format('d/m/Y H:i') ?? '—' }}</td>
        </tr>
        <tr>
          <th>Comentarios / Notas finales</th>
          <td>{{ $orden->comentarios ?? '—' }}</td>
        </tr>
      </tbody>
    </table>

    <div class="actions">
      <button class="btn btn-print" onclick="window.print()">Imprimir / Guardar como PDF</button>
      <button class="btn btn-close" onclick="window.close()">Cerrar</button>
    </div>

    <footer style="margin-top:24px; text-align:center; color:#777;">
      <small>Invenet · Sistema de inventario - Escuela Superior de Comercio N° 44</small>
    </footer>
  </div>
</body>
</html>
