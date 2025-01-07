<?php

namespace App\Http\Controllers;

use App\Models\Dependency;
use Illuminate\Http\Request;

class DependencyController extends Controller
{
    /**
     * Mostrar la lista de dependencias con paginación.
     */
    public function index()
    {
        $dependencies = Dependency::orderBy('name', 'asc')->paginate(10);
        return view('admin.dependencies.index', compact('dependencies'));
    }

    /**
     * Guardar una nueva dependencia.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'activo' => 'required|boolean',
        ]);

        Dependency::create($request->only('name', 'activo'));

        return redirect()->route('dependencies.index')->with('success', 'Dependencia creada exitosamente.');
    }

    /**
     * Actualizar una dependencia existente.
     */
    public function update(Request $request, Dependency $dependency)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'activo' => 'required|boolean',
        ]);

        $dependency->update($request->only('name', 'activo'));

        return redirect()->route('dependencies.index')->with('success', 'Dependencia actualizada exitosamente.');
    }

    /**
     * Eliminar una dependencia.
     */
    public function destroy(Dependency $dependency)
    {
        try {
            $dependency->delete();
            return redirect()->route('dependencies.index')->with('success', 'Dependencia eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('dependencies.index')->withErrors(['error' => 'No se puede eliminar esta dependencia porque está asociada a audiencias.']);
        }
    }
}
