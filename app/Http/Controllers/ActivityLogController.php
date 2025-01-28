<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistorialLog;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

class ActivityLogController extends Controller
{
    public function index()
    {
        return view('admin.activity-logs.index');
    }
    public function activityLogsDatatables()
    {
        return FacadesDataTables::eloquent(HistorialLog::orderBy('fecha_accion', 'desc'))
                ->addColumn('btn', 'activity-logs.actions')
                ->rawColumns(['btn'])
                ->toJson();
    }
}
