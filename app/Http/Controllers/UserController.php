<?php

namespace App\Http\Controllers;

use App\Models\HistorialLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

class UserController extends Controller
{
    /**
     * Display the users view.
     */
    public function index()
    {
        return view('admin.users.index');
    }

    /**
     * Fetch users data for DataTables.
     */
    public function getUsersData()
    {
        $users = User::query();

        return FacadesDataTables::of($users)
            ->addColumn('actions', function ($user) {
                return view('admin.users.partials.actions', compact('user'))->render();
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nickname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        $this->log(
            'Creación',
            'UserController',
            "Se creó el usuario: {$user->name} | {$user->nickname} | {$user->email}"
        );

        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente.');
    }

    public function show(User $user)
    {
        try {
            return response()->json($user, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error al obtener los detalles del usuario.'], 500);
        }
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'nickname' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:8|confirmed',
            ]);
    
            if (!empty($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']);
            }
    
            $user->update($validated);

            $this->log(
                'Actualización',
                'UserController',
                "Se actualizó el usuario: {$user->name} | {$user->nickname} | {$user->email}"
            );
    
            return response()->json(['success' => 'Usuario actualizado exitosamente.'], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error al actualizar el usuario.',
                'details' => $th->getMessage(), // Agrega el mensaje del error
            ], 500);
        }
    }
    
    
    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        try {

            $userName = $user->name;
            $userNickname = $user->nickname;
            $userEmail = $user->email;

            $user->delete();

            $this->log(
                'Eliminación',
                'UserController',
                "Se eliminó el usuario: {$userName} | {$userNickname} | {$userEmail}"
            );
    
            // Respuesta para AJAX
            return response()->json([
                'success' => true,
                'message' => 'Usuario eliminado exitosamente.'
            ]);
        } catch (\Throwable $th) {
            // Respuesta para AJAX en caso de error
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el usuario.'
            ], 500); // Código de error HTTP 500 (Internal Server Error)
        }
    }

    public function log($accion, $lugar, $informacion)
    {
        HistorialLog::create([
            'usuario_id' => Auth::user()->id,
            'usuario_nombre' => Auth::user()->name,
            'modulo' => 'Usuario',
            'accion' => $accion,
            'lugar' => $lugar,
            'informacion' => $informacion,
            'fecha_accion' => now(),
        ]);
    }
    
}