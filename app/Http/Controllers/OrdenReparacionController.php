<?php

namespace App\Http\Controllers;

use App\Models\OrdenReparacion;
use App\Models\Reporte;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class OrdenReparacionController extends Controller
{
     // Mostrar todas las órdenes de reparación
    public function index()
    {
        return OrdenReparacion::with(['reporte', 'tecnico'])->get();
    }

    // Crear orden de reparación
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reporte_id' => 'required|exists:reportes,id',
            'tecnico_id' => 'required|exists:users,id',
            'descripcion'   => 'nullable|string',
        ]);

        // Validar que el técnico sea realmente un usuario con rol "tecnico"
        $tecnico = User::find($validated['tecnico_id']);

        if (!$tecnico || $tecnico->role !== 'tecnico') {
        return response()->json(['error' => 'El usuario seleccionado no es un técnico válido.'], 403);
        }

        $orden = OrdenReparacion::create([
            'reporte_id' => $validated['reporte_id'],
            'tecnico_id' => $validated['tecnico_id'],
            'descripcion'   => $validated['descripcion'] ?? null,
            'estado'     => 'pendiente',

        ]);

        return response()->json($orden, 201);
    }

   // Mostrar una orden específica
    public function show(OrdenReparacion $ordenReparacion)
    {
        return $ordenReparacion->load(['reporte', 'tecnico']);
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

    // Ver orden
    public function verOrden($id)
    {
    $orden = OrdenReparacion::with(['reporte', 'tecnico'])->findOrFail($id);
    return view('ordenes/pdf', compact('orden'));
    }



    // Completar una orden (solo el técnico asignado)
    public function completarOrden(Request $request, $id)
    {
    $request->validate([
        'descripcion' => 'required|string',
    ]);

    $orden = OrdenReparacion::findOrFail($id);

    // Verificación: solo el técnico asignado puede completarla
    if ($orden->tecnico_id !== auth()->id()) {
        return response()->json(['error' => 'No autorizado'], 403);
    }

    $orden->update([
        'descripcion' => $request->descripcion,
        'estado'     => 'completada',

    ]);

    return response()->json(['mensaje' => 'Orden completada con éxito', 'orden' => $orden]);

    }


    //Resumen (solo administradores)
    public function resumen(Request $request)
    {
    if ($request->user()->role !== 'administrador') {
        return response()->json(['message' => 'Acceso no autorizado'], 403);
    }

    $resumenes = [
        'pendientes' => OrdenReparacion::where('estado', 'pendiente')->count(),
        'en_proceso' => OrdenReparacion::where('estado', 'en_proceso')->count(),
        'completadas' => OrdenReparacion::where('estado', 'completada')->count(),
        'total' => OrdenReparacion::count(),
    ];

    return response()->json($resumenes);
    }

    // Filtrar órdenes por estado
    public function filtrarPorEstado($estado)
    {
        if (!in_array($estado, ['pendiente', 'en_proceso', 'completada'])) {
            return response()->json(['error' => 'Estado no válido'], 422);
        }

        $ordenes = OrdenReparacion::where('estado', $estado)
            ->with(['reporte', 'tecnico'])
            ->get();

        return response()->json($ordenes);
    }

}
