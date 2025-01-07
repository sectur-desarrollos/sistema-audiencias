<?php

namespace App\Http\Controllers;

use App\Models\Audience;
use App\Models\AudienceStatus;
use App\Models\ContactType;
use App\Models\Dependency;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AudienceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $audiences = Audience::with('contactType', 'dependency', 'status')->get();
        return view('admin.audiences.index', compact('audiences'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $contactTypes = ContactType::where('activo', true)->get();
        $dependencies = Dependency::where('activo', true)->get();
        $statuses = AudienceStatus::where('activo', true)->get();
        return view('admin.audiences.create', compact('contactTypes', 'dependencies', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'nullable|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'asunto' => 'required|string',
            'hora_llegada' => 'required',
            'fecha_llegada' => 'required|date',
            'telefono' => 'nullable|string|max:15|regex:/^\d+$/',
            'cargo' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'observacion' => 'nullable|string',
            'contact_type_id' => 'required|exists:contact_types,id',
            'dependency_id' => 'required|exists:dependencies,id',
            'audience_status_id' => 'required|exists:audience_statuses,id',
            // Acompañantes
            'companions.*.nombre' => 'nullable|string|max:255',
            'companions.*.telefono' => 'nullable|string|max:15',
            'companions.*.email' => 'nullable|email|max:255',
            'companions.*.cargo' => 'nullable|string|max:255',
        ]);

        // Generar el folio único
        $nombreInicial = strtoupper(substr($validated['nombre'], 0, 1));
        $apellidoInicial = strtoupper(substr($validated['apellido_paterno'] ?? 'X', 0, 1));
        $fechaActual = now()->format('Ymd-His'); // Fecha y hora actual

        $folio = "{$nombreInicial}{$apellidoInicial}-{$fechaActual}";

        // Agregar el folio al registro
        $validated['folio'] = $folio;

        $audience = Audience::create($validated);

        // Guardar acompañantes
        if (!empty($request->companions)) {
            foreach ($request->companions as $companion) {
                $audience->companions()->create($companion);
            }
        }

        return redirect()->route('audiences.index')->with('success', 'Audiencia creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Audience $audience)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Audience $audience)
    {
        $contactTypes = ContactType::where('activo', true)->get();
        $dependencies = Dependency::where('activo', true)->get();
        $statuses = AudienceStatus::where('activo', true)->get();
        return view('admin.audiences.edit', compact('audience','contactTypes', 'dependencies', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Audience $audience)
    {
        // Validar los datos ingresados
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'nullable|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'asunto' => 'required|string',
            'hora_llegada' => 'required',
            'fecha_llegada' => 'required|date',
            'telefono' => 'nullable|string|max:15|regex:/^\d+$/',
            'cargo' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'observacion' => 'nullable|string',
            'contact_type_id' => 'required|exists:contact_types,id',
            'dependency_id' => 'required|exists:dependencies,id',
            'audience_status_id' => 'required|exists:audience_statuses,id',
            // Acompañantes
            'companions.*.nombre' => 'nullable|string|max:255',
            'companions.*.telefono' => 'nullable|string|max:15',
            'companions.*.email' => 'nullable|email|max:255',
            'companions.*.cargo' => 'nullable|string|max:255',
        ]);

        // Actualizar el registro
        $audience->update($validated);

        // Actualizar acompañantes
        $audience->companions()->delete(); // Elimina los anteriores
        if (!empty($request->companions)) {
            foreach ($request->companions as $companion) {
                $audience->companions()->create($companion);
            }
        }

        // Redirigir a la lista de audiencias con un mensaje de éxito
        return redirect()->route('audiences.index')->with('success', 'Audiencia actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Audience $audience)
    {
        $audience->delete();
        return redirect()->route('audiences.index')->with('success', 'Audiencia eliminada exitosamente.');
    }

    public function generatePDF(Audience $audience)
    {
        $pdf = Pdf::loadView('admin.audiences.pdf-4', compact('audience'));
    
        // Tamaño personalizado: Media Cuartilla Vertical (148 x 210 mm)
        $pdf->setPaper([0, 0, 419.53, 250], 'portrait');
        return $pdf->stream('audiencia_' . $audience->folio . '.pdf');
    }

    public function generateCompaniesPDF(Audience $audience)
    {
        $pdf = Pdf::loadView('admin.audiences.pdf-5', compact('audience'));
    
        // Tamaño personalizado: Media Cuartilla Vertical (148 x 210 mm)
        $pdf->setPaper([0, 0, 419.53, 250], 'portrait');
        // $pdf->setPaper([0, 0, 450, 250], 'portrait');

        return $pdf->stream('audiencia_' . $audience->folio . '.pdf');
    }

    

}
