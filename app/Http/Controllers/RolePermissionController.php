<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    public function index()
    {
        $roles = Role::where('guard_name', 'web')
            ->with('permissions')
            ->orderBy('name')
            ->get();

        $permissions = Permission::where('guard_name', 'web')
            ->orderBy('name')
            ->get();

        return view('beheer.rol-permissies.index', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permission_id' => 'required|exists:permissions,id',
        ]);

        $role = Role::where('guard_name', 'web')
            ->findOrFail($request->role_id);

        $permission = Permission::where('guard_name', 'web')
            ->findOrFail($request->permission_id);

        if ($role->hasPermissionTo($permission)) {
            return redirect()
                ->route('admin.role-permissions.index')
                ->with('error', 'Deze permissie is al aan deze rol gekoppeld.');
        }

        $role->givePermissionTo($permission);

        return redirect()
            ->route('admin.role-permissions.index')
            ->with('success', 'Permissie is gekoppeld aan de rol!');
    }

    public function destroy(Role $role, Permission $permission)
    {
        if ($role->guard_name !== 'web' || $permission->guard_name !== 'web') {
            abort(404);
        }

        $role->revokePermissionTo($permission);

        return redirect()
            ->route('admin.role-permissions.index')
            ->with('success', 'Permissie is losgekoppeld van de rol!');
    }
}
