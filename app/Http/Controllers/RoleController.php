<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    // Alle rollen bekijken
    public function index()
    {
        $roles = Role::where('guard_name', 'web')
            ->orderBy('name')
            ->get();

        return view('beheer.rollen.index', compact('roles'));
    }

    // Formulier om een rol toe te voegen
    public function create()
    {
        return view('beheer.rollen.create');
    }

    // Nieuwe rol opslaan
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->where('guard_name', 'web'),
            ],
        ]);

        Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Rol is toegevoegd!');
    }

    // Formulier om een rol te bewerken
    public function edit(Role $role)
    {
        return view('beheer.rollen.edit', compact('role'));
    }

    // Gewijzigde rol opslaan
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')
                    ->where('guard_name', 'web')
                    ->ignore($role->id),
            ],
        ]);

        $role->update([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Rol is aangepast!');
    }

    // Rol verwijderen
    public function destroy(Role $role)
    {
        // Voorkom dat de admin-rol per ongeluk wordt verwijderd
        if ($role->name === 'admin' && $role->guard_name === 'web') {
            return redirect()
                ->route('admin.roles.index')
                ->with('error', 'De admin-rol kan niet worden verwijderd.');
        }

        $role->delete();

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Rol is verwijderd!');
    }
}