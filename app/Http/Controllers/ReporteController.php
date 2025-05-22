<?php

namespace App\Http\Controllers;

use App\Models\Reporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReporteController extends Controller
{
    // Listar todos los reportes (admin y técnicos)
    public function index()
    {
        $reportes = Reporte::with(['usuario', 'dispositivo'])->orderBy('created_at', 'desc')->get();
        return response()->json($reportes);
    }

    // Crear un nuevo reporte (docente)
    public function store(Request $request)
    {
        $request->validate([
            'dispositivo_id' => 'required|exists:dispositivos,id',
            'descripcion' => 'required|string|max:1000',
        ]);

        $reporte = Reporte::create([
            'user_id' => Auth::id(),
            'dispositivo_id' => $request->dispositivo_id,
            'descripcion' => $request->descripcion,
            'estado' => 'pendiente'
        ]);

        return response()->json($reporte, 201);
    }

    // Actualizar estado (ej: marcar como revisado)
    public function update(Request $request, $id)
    {
        $reporte = Reporte::findOrFail($id);

        $request->validate([
            'estado' => 'required|in:pendiente,revisado'
        ]);

        $reporte->estado = $request->estado;
        $reporte->save();

        return response()->json($reporte);
    }

    // Eliminar un reporte
    public function destroy($id)
    {
        $reporte = Reporte::findOrFail($id);
        $reporte->delete();

        return response()->json(['mensaje' => 'Reporte eliminado correctamente']);
    }
}
