<?php

namespace App\Http\Controllers;

use App\Models\Dispositivo;
use Illuminate\Http\Request;

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
        $request->validate([
            'tipo' => 'required|in:CPU,netbook,televisor,proyector,monitor,router,switch',
            'marca' => 'required|string|max:255',
            'modelo' => 'nullable|string|max:255',
            'nro_serie' => 'nullable|string|unique:dispositivos',
            'ubicacion' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'estado' => 'required|in:activo,baja,en reparacion'
        ]);

        $dispositivo = Dispositivo::create($request->all());

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
}
