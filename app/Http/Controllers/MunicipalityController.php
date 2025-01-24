<?php

namespace App\Http\Controllers;

use App\Models\Municipality;
use App\Models\State;
use Illuminate\Http\Request;

class MunicipalityController extends Controller
{
    public function index()
    {
        $municipalities = Municipality::with('state')->orderBy('name', 'asc')->paginate(20);
        $states = State::where('activo', true)->orderBy('name', 'asc')->get(); // Para el select de estados
        return view('admin.municipalities.index', compact('municipalities', 'states'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'state_id' => 'required|exists:states,id',
            'name' => 'required|string|max:255',
            'activo' => 'required|boolean',
        ]);

        Municipality::create($request->only('state_id', 'name', 'activo'));

        return redirect()->route('municipalities.index')->with('success', 'Municipio creado exitosamente.');
    }

    public function update(Request $request, Municipality $municipality)
    {
        $request->validate([
            'state_id' => 'required|exists:states,id',
            'name' => 'required|string|max:255',
            'activo' => 'required|boolean',
        ]);

        $municipality->update($request->only('state_id', 'name', 'activo'));

        return redirect()->route('municipalities.index')->with('success', 'Municipio actualizado exitosamente.');
    }

    public function destroy(Municipality $municipality)
    {
        try {
            $municipality->delete();
            return redirect()->route('municipalities.index')->with('success', 'Municipio eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('municipalities.index')->withErrors(['error' => 'No se puede eliminar este municipio porque está relacionado con otros registros.']);
        }
    }

        // Listado de información para hacer el select dependiente
        public function getByState($stateId)
        {
    
            try {
                return Municipality::where('state_id', $stateId)->where('activo', true)->get(['id', 'name']);
            } catch (\Throwable $th) {
                return [];
            }
        }

}
