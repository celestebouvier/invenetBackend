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
        'tipo' => 'sometimes|required|in:CPU,netbook,televisor,proyector,monitor,router,switch',
        'marca' => 'sometimes|required|string|max:255',
        'modelo' => 'nullable|string|max:255',
        'nro_serie' => 'nullable|string|unique:dispositivos,nro_serie,' . $id,
        'ubicacion' => 'sometimes|required|string|max:255',
        'descripcion' => 'nullable|string',
        'estado' => 'sometimes|required|in:activo,baja,en reparacion',
        ], [
        'tipo.required' => 'El campo tipo es obligatorio si se envía.',
        'tipo.in' => 'El tipo de dispositivo debe ser uno de los siguientes: CPU, netbook, televisor, proyector, monitor, router o switch.',

        'marca.required' => 'El campo marca es obligatorio si se envía.',
        'marca.string' => 'La marca debe ser una cadena de texto.',
        'marca.max' => 'La marca no debe tener más de 255 caracteres.',

        'modelo.string' => 'El modelo debe ser una cadena de texto.',
        'modelo.max' => 'El modelo no debe tener más de 255 caracteres.',

        'nro_serie.string' => 'El número de serie debe ser una cadena de texto.',
        'nro_serie.unique' => 'Ese número de serie ya está registrado para otro dispositivo.',

        'ubicacion.required' => 'El campo ubicación es obligatorio si se envía.',
        'ubicacion.string' => 'La ubicación debe ser una cadena de texto.',
        'ubicacion.max' => 'La ubicación no debe tener más de 255 caracteres.',

        'descripcion.string' => 'La descripción debe ser una cadena de texto.',

        'estado.required' => 'El campo estado es obligatorio si se envía.',
        'estado.in' => 'El estado debe ser uno de los siguientes: activo, baja o en reparación.',
        ]);


        $dispositivo->update($request->only([
        'tipo', 'marca', 'modelo', 'nro_serie', 'ubicacion', 'descripcion', 'estado'
         ]));

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

    // Pasarlo a la vista
    return Pdf::loadView('qr-pdf', [
        'dispositivo' => $dispositivo
    ])->download("QR_Dispositivo_{$id}.pdf");
    }

    public function verQr($id)
    {
    $dispositivo = Dispositivo::findOrFail($id);
    return view('qr-pdf', compact('dispositivo'));
    }


}
