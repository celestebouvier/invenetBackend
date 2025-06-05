<?php

namespace App\Http\Controllers;

use App\Models\OrdenReparacion;
use App\Models\Reporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class OrdenReparacionController extends Controller
{
     // Mostrar todas las órdenes de reparación
    public function index()
    {
        return OrdenReparacion::with(['reporte', 'tecnico', 'dispositivo'])->get();
    }

    // Crear orden de reparación
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reporte_id' => 'required|exists:reportes,id',
            'tecnico_id' => 'required|exists:users,id',
            'detalles'   => 'nullable|string',
        ]);

        $orden = OrdenReparacion::create([
            'reporte_id' => $validated['reporte_id'],
            'tecnico_id' => $validated['tecnico_id'],
            'detalles'   => $validated['detalles'] ?? null,
            'estado'     => 'pendiente',
            'completada' => false,
        ]);

        return response()->json($orden, 201);
    }

   // Mostrar una orden específica
    public function show(OrdenReparacion $ordenReparacion)
    {
        return $ordenReparacion->load(['reporte', 'tecnico', 'dispositivo']);
    }


    //Eliminar una orden
    public function destroy(OrdenReparacion $ordenReparacion)
    {
        $ordenReparacion->delete();

        return response()->json(['mensaje' => 'Orden eliminada con éxito']);
    }

    // Generar PDF de una orden
    public function generarPDF($id)
    {
        $orden = OrdenReparacion::with(['reporte', 'tecnico'])->findOrFail($id);
        $pdf = Pdf::loadView('ordenes.pdf', compact('orden'));

        return $pdf->download('orden_reparacion_'.$id.'.pdf');
    }

    // Completar una orden (solo el técnico asignado)
    public function completarOrden(Request $request, $id)
    {
    $request->validate([
        'detalles' => 'required|string',
    ]);

    $orden = OrdenReparacion::findOrFail($id);

    // Verificación: solo el técnico asignado puede completarla
    if ($orden->tecnico_id !== auth()->id()) {
        return response()->json(['error' => 'No autorizado'], 403);
    }

    $orden->update([
        'detalles' => $request->detalles,
        'estado'     => 'completada',
        'completada' => true,
    ]);

    return response()->json(['mensaje' => 'Orden completada con éxito', 'orden' => $orden]);

    }


    //Resumen (solo administradores)
    public function resumen(Request $request)
    {
    if ($request->user()->role !== 'administrador') {
        return response()->json(['message' => 'Acceso no autorizado'], 403);
    }

    $resumen = [
        'pendientes' => OrdenReparacion::where('estado', 'pendiente')->count(),
        'en_proceso' => OrdenReparacion::where('estado', 'en_proceso')->count(),
        'completadas' => OrdenReparacion::where('estado', 'completada')->count(),
        'total' => OrdenReparacion::count(),
    ];

    return response()->json($resumen);
    }

    // Filtrar órdenes por estado
    public function filtrarPorEstado($estado)
    {
        if (!in_array($estado, ['pendiente', 'en_proceso', 'completada'])) {
            return response()->json(['error' => 'Estado no válido'], 422);
        }

        $ordenes = OrdenReparacion::where('estado', $estado)
            ->with(['reporte', 'tecnico', 'dispositivo'])
            ->get();

        return response()->json($ordenes);
    }

}
