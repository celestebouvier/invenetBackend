<?php

namespace App\Http\Controllers;

use App\Models\Reporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReporteController extends Controller
{
    // Listar todos los reportes (solo admins, opcionalmente filtrado por estado)
    public function index()
    {
        if (Auth::user()->role !== 'administrador') {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $estado = $request->query('estado');

        $reportes = Reporte::with(['usuario', 'dispositivo'])
         ->when($estado, function ($query, $estado) {
            return $query->where('estado', $estado);
        })
        ->orderBy('created_at', 'desc')
        ->get();


        return response()->json($reportes);
    }

    // Crear un nuevo reporte (docente o administrador)
    public function store(Request $request)
    {
        $user = Auth::user();

        // Verificar que el usuario sea 'administrador' o 'docente'
        if (!in_array($user->role, ['administrador', 'docente'])) {
        return response()->json(['mensaje' => 'No autorizado.'], 403);
        }

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

    // Actualizar estado
    public function updateEstado(Request $request, $id)
    {

        if (Auth::user()->role !== 'administrador') {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $request->validate([
            'estado' => 'required|in:pendiente,revisado'
        ]);

        $reporte = Reporte::findOrFail($id);
        $reporte->estado = $request->estado;
        $reporte->save();

        return response()->json(['message' => 'Estado actualizado correctamente', 'reporte' => $reporte]);
    }

    // Eliminar un reporte
    public function destroy($id)
    {
        if (Auth::user()->role !== 'administrador') {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $reporte = Reporte::findOrFail($id);
        $reporte->delete();

        return response()->json(['mensaje' => 'Reporte eliminado correctamente']);
    }
}
