<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    // Alle permissies bekijken
    public function index()
    {
        $permissions = Permission::where('guard_name', 'web')
            ->orderBy('name')
            ->get();

        return view('beheer.permissies.index', compact('permissions'));
    }

    // Formulier om een permissie toe te voegen
    public function create()
    {
        return view('beheer.permissies.create');
    }

    // Nieuwe permissie opslaan
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
        ]);

        Permission::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', 'Permissie is toegevoegd!');
    }

    // Formulier om een permissie te bewerken
    public function edit(Permission $permission)
    {
        return view('beheer.permissies.edit', compact('permission'));
    }

    // Gewijzigde permissie opslaan
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('permissions', 'name')
                    ->where('guard_name', 'web')
                    ->ignore($permission->id),
            ],
        ]);

        $permission->update([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', 'Permissie is aangepast!');
    }

    // Permissie verwijderen
    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', 'Permissie is verwijderd!');
    }
}