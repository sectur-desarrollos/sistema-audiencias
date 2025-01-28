<?php

namespace App\Http\Controllers;

use App\Models\Audience;
use App\Models\AudienceStatus;
use App\Models\ContactType;
use App\Models\Dependency;
use App\Models\State;
use App\Models\Municipality;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

class AudienceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.audiences.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $contactTypes = ContactType::where('activo', true)->get();
        $dependencies = Dependency::where('activo', true)->get();
        $statuses = AudienceStatus::where('activo', true)->get();
        $states = State::where('activo', true)->get(); // Cargar estados activos
        $municipalities = Municipality::where('activo', true)->get(); // Cargar municipios activos
        return view('admin.audiences.create', compact('contactTypes', 'dependencies', 'statuses', 'states', 'municipalities'));
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
            'contact_type_id' => 'nullable|string',
            // 'dependency_id' => 'required|exists:dependencies,id',
            'dependency_id' => 'nullable|string',
            'audience_status_id' => 'required|exists:audience_statuses,id',
            // Acompañantes
            'companions.*.nombre' => 'nullable|string|max:255',
            'companions.*.telefono' => 'nullable|string|max:15',
            'companions.*.email' => 'nullable|email|max:255',
            'companions.*.cargo' => 'nullable|string|max:255',
            // Estado y Municipio
            'state_id' => 'required|exists:states,id',
            'municipality_id' => 'nullable|exists:municipalities,id',
        ]);

        // Verificar y/o crear dependencia si es necesario
        if (!empty($validated['dependency_id']) && !is_numeric($validated['dependency_id'])) {
            $validated['dependency_id'] = $this->getOrCreateDependency($validated['dependency_id']);
        }
        // Verificar y/o crear dependencia si es necesario
        if (!empty($validated['contact_type_id']) && !is_numeric($validated['contact_type_id'])) {
            $validated['contact_type_id'] = $this->getOrCreateContactType($validated['contact_type_id']);
        }

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

    public function show(Audience $audience)
    {
       try {
            // Devuelve la audiencia junto con las relaciones necesarias en formato JSON
            return response()->json($audience->load('status', 'dependency', 'contactType', 'state', 'municipality'));
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error al eliminar la audiencia.'], 500);
       }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Audience $audience)
    {
        $contactTypes = ContactType::where('activo', true)->get();
        $dependencies = Dependency::where('activo', true)->get();
        $statuses = AudienceStatus::where('activo', true)->get();
        $states = State::where('activo', true)->get(); // Cargar estados activos
        $municipalities = Municipality::where('activo', true)->get(); // Cargar municipios activos
        return view('admin.audiences.edit', compact('audience', 'contactTypes', 'dependencies', 'statuses', 'states', 'municipalities'));
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
            // Estado y Municipio
            'state_id' => 'required|exists:states,id',
            'municipality_id' => 'nullable|exists:municipalities,id',
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
        try {
            $audience->delete();
            return response()->json(['success' => 'Audiencia eliminada correctamente.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error al eliminar la audiencia.'], 500);
        }
    }

    private function getOrCreateDependency(string $dependencyName): int
    {
        // Buscar o crear la dependencia
        $dependency = Dependency::firstOrCreate(
            ['name' => $dependencyName],
            ['activo' => true] // Otros valores por defecto si son necesarios
        );
    
        return $dependency->id;
    }

    private function getOrCreateContactType(string $contactTypeName): int
    {
        // Buscar o crear el tipo de contacto
        $contactType = ContactType::firstOrCreate(
            ['name' => $contactTypeName],
            ['activo' => true] // Otros valores por defecto si son necesarios
        );
    
        return $contactType->id;
    }

    
    // PDF Con toda la información
    public function generatePDF(Audience $audience)
    {
        $pdf = Pdf::loadView('admin.audiences.pdf-4', compact('audience'));
    
        // Tamaño personalizado: Media Cuartilla Vertical (148 x 210 mm)
        $pdf->setPaper([0, 0, 419.53, 250], 'portrait');
        return $pdf->stream('audiencia_' . $audience->folio . '.pdf');
    }

    // PDF con solo los nombres de los acompañantes
    public function generateCompaniesPDF(Audience $audience)
    {
        $pdf = Pdf::loadView('admin.audiences.pdf-5', compact('audience'));
    
        // Tamaño personalizado: Media Cuartilla Vertical (148 x 210 mm)
        $pdf->setPaper([0, 0, 419.53, 250], 'portrait');
        // $pdf->setPaper([0, 0, 450, 250], 'portrait');

        return $pdf->stream('audiencia_' . $audience->folio . '.pdf');
    }

    // Listado de información de audiencias para Datatables
    public function getAudiencesData()
    {
        return FacadesDataTables::eloquent(
            Audience::with('status', 'dependency', 'contactType', 'state', 'municipality') // Carga la relación 'status'
                ->orderByRaw("
                    CASE 
                        WHEN (SELECT name FROM audience_statuses WHERE id = audiences.audience_status_id) = 'Iniciado' THEN 1
                        WHEN (SELECT name FROM audience_statuses WHERE id = audiences.audience_status_id) = 'En Proceso' THEN 2
                        ELSE 3
                    END
                ")
                ->orderBy('fecha_llegada', 'desc') // Orden secundario por fecha
        )
        ->addColumn('nombre', function ($row) {
            return $row->nombre . ' ' . $row->apellido_paterno . ' ' . $row->apellido_materno;
        })
        ->filterColumn('nombre', function ($query, $keyword) {
            $query->whereRaw("CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) LIKE ?", ["%{$keyword}%"]);
        })
        ->addColumn('status_badge', function ($row) {
            if ($row->status) {
                return '<span title="' . $row->status->description . '" class="badge"
                        style="background-color: ' . $row->status->color . '; color: #fff;">
                        ' . $row->status->name . '</span>';
            }
            return '<span class="badge bg-secondary">Sin Estado</span>';
        })
        ->addColumn('actions', function ($row) {
            return view('admin.audiences.partials.actions', compact('row'))->render();
        })
        ->rawColumns(['status_badge', 'actions'])
        ->toJson();
    }




    /*       idea para filtros              */
    public function showFilterView()
    {
        return view('admin.audiences.filter');
    }

    public function filter(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $query = Audience::with('status', 'dependency', 'contactType');

        if ($startDate && $endDate) {
            $query->whereBetween('fecha_llegada', [$startDate, $endDate]);
        }

        return FacadesDataTables::eloquent(
            $query->orderBy('fecha_llegada', 'desc')
        )
        ->addColumn('nombre', function ($row) {
            return $row->nombre . ' ' . $row->apellido_paterno . ' ' . $row->apellido_materno;
        })
        ->filterColumn('nombre', function ($query, $keyword) {
            $query->whereRaw("CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) LIKE ?", ["%{$keyword}%"]);
        })
        ->addColumn('status_badge', function ($row) {
            if ($row->status) {
                return '<span title="' . $row->status->description . '" class="badge"
                        style="background-color: ' . $row->status->color . '; color: #fff;">
                        ' . $row->status->name . '</span>';
            }
            return '<span class="badge bg-secondary">Sin Estado</span>';
        })
        ->addColumn('actions', function ($row) {
            return view('admin.audiences.partials.actions', compact('row'))->render();
        })
        ->rawColumns(['status_badge', 'actions'])
        ->toJson();
    }

    public function exportToPDF(Request $request)
    {
        $audienceIds = $request->ids;

        $query = Audience::with('status', 'dependency', 'contactType', 'state', 'municipality');

        if ($audienceIds) {
            $query->whereIn('id', $audienceIds);
        }

        $audience = $query->get();

        // dd($audience);

        $pdf = Pdf::loadView('admin.audiences.pdf-3', compact('audience'));
        $pdf->setPaper([0, 0, 419.53, 250], 'portrait');

        return $pdf->stream('audiencia.pdf');
    }
}
