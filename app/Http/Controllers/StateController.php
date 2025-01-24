<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index()
    {
        $states = State::orderBy('name', 'asc')->paginate(10);
        return view('admin.states.index', compact('states'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'activo' => 'required|boolean',
        ]);

        State::create($request->only('name', 'activo'));

        return redirect()->route('states.index')->with('success', 'State created successfully.');
    }

    public function update(Request $request, State $state)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'activo' => 'required|boolean',
        ]);

        $state->update($request->only('name', 'activo'));

        return redirect()->route('states.index')->with('success', 'State updated successfully.');
    }

    public function destroy(State $state)
    {
        try {
            $state->delete();
            return redirect()->route('states.index')->with('success', 'State deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('states.index')->withErrors(['error' => 'This state cannot be deleted because it is associated with municipalities.']);
        }
    }
}
