<?php

namespace App\Http\Controllers;

use App\Models\AudienceStatus;
use Illuminate\Http\Request;

class AudienceStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statuses = AudienceStatus::orderBy('name', 'asc')->paginate(10);
        return view('admin.audience-statuses.index', compact('statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7|regex:/^#[a-fA-F0-9]{6}$/',
            'activo' => 'required|boolean',
        ]);

        AudienceStatus::create($request->only('name', 'description', 'color', 'activo'));

        return redirect()->route('audience-statuses.index')->with('success', 'Estado de audiencia creado exitosamente.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AudienceStatus $audienceStatus)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7|regex:/^#[a-fA-F0-9]{6}$/',
            'activo' => 'required|boolean',
        ]);

        $audienceStatus->update($request->only('name', 'description', 'color', 'activo'));

        return redirect()->route('audience-statuses.index')->with('success', 'Estado de audiencia actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AudienceStatus $audienceStatus)
    {
        try {
            $audienceStatus->delete();
            return redirect()->route('audience-statuses.index')->with('success', 'Estado de audiencia eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('audience-statuses.index')->withErrors(['error' => 'No se puede eliminar este estado porque está asociado a audiencias.']);
        }
    }
}
