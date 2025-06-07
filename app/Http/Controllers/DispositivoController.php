<?php

namespace App\Http\Controllers;

use App\Models\Dispositivo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;

class DispositivoController extends Controller
{
    // Listar todos los dispositivos
    public function index()
    {
        return Dispositivo::all();
    }

    // Crear un nuevo dispositivo
    public function store(Request $request)
    {
    $validated = $request->validate([
        'tipo' => 'required|in:CPU,netbook,televisor,proyector,monitor,router,switch',
        'marca' => 'required|string|max:255',
        'modelo' => 'nullable|string|max:255',
        'nro_serie' => 'nullable|string|unique:dispositivos',
        'ubicacion' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'estado' => 'required|in:activo,baja,en reparacion'
    ]);

    //  Generar el codigo_qr automáticamente al crear el dispositivo
    $validated['codigo_qr'] = Str::uuid(); // genera un UUID único

    // Crear el dispositivo con todos los datos
    $dispositivo = Dispositivo::create($validated);

    return response()->json($dispositivo, 201);
    }

    // Actualizar un dispositivo
    public function update(Request $request, $id)
    {
        $dispositivo = Dispositivo::findOrFail($id);

        $request->validate([
            'tipo' => 'required|in:CPU,netbook,televisor,proyector,monitor,router,switch',
            'marca' => 'required|string|max:255',
            'modelo' => 'nullable|string|max:255',
            'nro_serie' => 'nullable|string|unique:dispositivos,nro_serie,' . $id,
            'ubicacion' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'estado' => 'required|in:activo,baja,en reparacion'
        ]);

        $dispositivo->update($request->all());

        return response()->json($dispositivo);
    }

    // Eliminar un dispositivo
    public function destroy($id)
    {
        $dispositivo = Dispositivo::findOrFail($id);
        $dispositivo->delete();

        return response()->json(['mensaje' => 'Dispositivo eliminado correctamente']);
    }

    // Ver un dispositivo (opcional)
    public function show($id)
    {
        return Dispositivo::findOrFail($id);
    }

    public function downloadQr($id)
    {
    $dispositivo = Dispositivo::findOrFail($id);
    $codigo_qr = $dispositivo->codigo_qr;

    $pdf = Pdf::loadView('qr-pdf', [
        'codigo_qr' => $codigo_qr,
        'id' => $dispositivo->id
    ]);

    return $pdf->download("QR_Dispositivo_{$id}.pdf");
    }

    public function verQr($id)
    {
    $dispositivo = Dispositivo::findOrFail($id);
    return view('qr', compact('dispositivo'));
    }


}
