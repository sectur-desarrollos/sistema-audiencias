<?php

namespace App\Http\Controllers;

use App\Models\ContactType;
use Illuminate\Http\Request;

class ContactTypeController extends Controller
{
        /**
     * Mostrar la lista de tipos de contacto con paginación.
     */
    public function index()
    {
        $contactTypes = ContactType::orderBy('name', 'asc')->paginate(10);
        return view('admin.contact-types.index', compact('contactTypes'));
    }

    /**
     * Guardar un nuevo tipo de contacto.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'activo' => 'required|boolean',
        ]);

        ContactType::create($request->only('name', 'activo'));

        return redirect()->route('contact-types.index')->with('success', 'Tipo de contacto creado exitosamente.');
    }

    /**
     * Actualizar un tipo de contacto existente.
     */
    public function update(Request $request, ContactType $contactType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'activo' => 'required|boolean',
        ]);

        $contactType->update($request->only('name', 'activo'));

        return redirect()->route('contact-types.index')->with('success', 'Tipo de contacto actualizado exitosamente.');
    }

    /**
     * Eliminar un tipo de contacto.
     */
    public function destroy(ContactType $contactType)
    {
        try {
            $contactType->delete();
            return redirect()->route('contact-types.index')->with('success', 'Tipo de contacto eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('contact-types.index')->withErrors(['error' => 'No se puede eliminar este tipo de contacto porque está asociado a audiencias.']);
        }
    }
}
