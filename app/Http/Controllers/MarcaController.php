<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marca;

class MarcaController extends Controller
{
    public function index()
    {
        return response()->json(Marca::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:15|unique:marcas,nombre',
        ]);

        $marca = Marca::create([
            'nombre' => $request->nombre,
        ]);

        return response()->json($marca, 201);
    }

    public function show($id)
    {
        $marca = Marca::find($id);

        if (!$marca) {
            return response()->json(['error' => 'Marca no encontrada'], 404);
        }

        return response()->json($marca, 200);
    }

    public function update(Request $request, $id)
    {
        $marca = Marca::find($id);

        if (!$marca) {
            return response()->json(['error' => 'Marca no encontrada'], 404);
        }

        $request->validate([
            'nombre' => 'required|string|max:15|unique:marcas,nombre,' . $id,
        ]);

        $marca->nombre = $request->nombre;
        $marca->save();

        return response()->json($marca, 200);
    }

    public function destroy($id)
    {
        $marca = Marca::find($id);

        if (!$marca) {
            return response()->json(['error' => 'Marca no encontrada'], 404);
        }

        $marca->delete();

        return response()->json(['mensaje' => 'Marca eliminada'], 200);
    }
}
