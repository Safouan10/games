<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    public function index()
    {
        $users = User::with('roles')
            ->orderBy('name')
            ->get();

        $roles = Role::where('guard_name', 'web')
            ->orderBy('name')
            ->get();

        return view('beheer.gebruiker-rollen.index', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($request->user_id);

        $role = Role::where('guard_name', 'web')
            ->findOrFail($request->role_id);

        if ($user->hasRole($role)) {
            return redirect()
                ->route('admin.user-roles.index')
                ->with('error', 'Deze rol is al aan deze gebruiker gekoppeld.');
        }

        $user->assignRole($role);

        return redirect()
            ->route('admin.user-roles.index')
            ->with('success', 'Rol is gekoppeld aan de gebruiker!');
    }

    public function destroy(User $user, Role $role)
    {
        if ($role->guard_name !== 'web') {
            abort(404);
        }

        // Voorkom dat een admin zichzelf zijn eigen admin-rol afneemt.
        if (
            $user->id === auth()->id() &&
            $role->name === 'admin'
        ) {
            return redirect()
                ->route('admin.user-roles.index')
                ->with('error', 'Je kunt je eigen admin-rol niet verwijderen.');
        }

        $user->removeRole($role);

        return redirect()
            ->route('admin.user-roles.index')
            ->with('success', 'Rol is verwijderd bij de gebruiker!');
    }
}
