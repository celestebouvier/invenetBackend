<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\OrdenReparacion;
use App\Models\Reporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdenReparacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return OrdenReparacion::get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $request->validate([
        'reporte_id' => 'required|exists:reportes,id',
        'tecnico_id' => 'required|exists:users,id',
        'detalles' => 'nullable|string',
    ]);

    $orden = OrdenReparacion::create($request->all());

    return response()->json($orden, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return OrdenReparacion::with(['dispositivo', 'usuario'])->findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrdenReparacion $ordenReparacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrdenReparacion $ordenReparacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrdenReparacion $ordenReparacion)
    {
        $orden = OrdenReparacion::findOrFail($id);
        $orden->delete();

        return response()->json(['mensaje' => 'Orden eliminada']);
    }

    public function generarPDF($id)
    {
    $orden = OrdenReparacion::with(['reporte', 'tecnico'])->findOrFail($id);
    $pdf = Pdf::loadView('ordenes.pdf', compact('orden'));

    return $pdf->download('orden_reparacion_'.$id.'.pdf');
    }


    public function completarOrden(Request $request, $id)
    {
    $request->validate([
        'detalles' => 'required|string',
    ]);

    $orden = OrdenReparacion::findOrFail($id);

    // Verificación opcional: solo el técnico asignado puede completarla
    if ($orden->tecnico_id !== auth()->id()) {
        return response()->json(['error' => 'No autorizado'], 403);
    }

    $orden->update([
        'detalles' => $request->detalles,
        'completada' => true,
    ]);

    return response()->json(['mensaje' => 'Orden completada con éxito', 'orden' => $orden]);

    }

    public function resumen(Request $request)
    {
    if ($request->user()->role !== 'administrador') {
        return response()->json(['message' => 'Acceso no autorizado'], 403);
    }

    $resumen = [
        'pendientes' => DB::table('ordenes_reparacion')->where('estado', 'pendiente')->count(),
        'en_proceso' => DB::table('ordenes_reparacion')->where('estado', 'en_proceso')->count(),
        'completadas' => DB::table('ordenes_reparacion')->where('estado', 'completada')->count(),
        'total' => DB::table('ordenes_reparacion')->count()
    ];

    return response()->json($resumen);
    }

}
