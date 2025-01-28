<?php

namespace App\Http\Controllers;

use App\Models\Audience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Mostrar formulario de login
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }
    
        return view('auth.login');
    }

    // Procesar el login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nickname' => 'required|string',
            'password' => 'required',
        ]);
    
        if (Auth::attempt(['nickname' => $credentials['nickname'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }
    
        return back()->withErrors([
            'nickname' => 'Las credenciales no son correctas.',
        ]);
    }

    // Procesar el logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function showDashboard()
    {
        $statuses = Audience::select('audience_status_id')
            ->with('status')
            ->get()
            ->groupBy('audience_status_id')
            ->map(function ($group) {
                return [
                    'name' => $group->first()->status->name ?? 'Sin Estado',
                    'color' => $group->first()->status->color ?? '#6c757d', // Color por defecto para "Sin Estado"
                    'count' => $group->count(),
                ];
            });
    
        return view('admin.dashboard.dashboard', compact('statuses'));
    }
    
}
