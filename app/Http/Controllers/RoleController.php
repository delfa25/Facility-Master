<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->string('q')->toString();
        $query = Role::query();
        if ($q !== '') {
            $query->where('name', 'like', "%{$q}%");
        }
        $roles = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('admin.role.index', compact('roles', 'q'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);
        
        $roles = Role::create(['name' => $request->name]);

        return redirect()->route('roles.index')->with('success', 'Rôle créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return view('admin.role.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::orderBy('name')->get();
        $rolePermissionIds = $role->permissions()->pluck('id')->toArray();
        $groupedPermissions = $permissions->groupBy(function ($perm) {
            $parts = explode('.', $perm->name, 2);
            return strtoupper($parts[0] ?? 'AUTRE');
        });
        return view('admin.role.edit', compact('role', 'permissions', 'rolePermissionIds', 'groupedPermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
        ]);
        $role->update(['name' => $request->name]);
        // Sync permissions if provided
        $permissionIds = $request->input('permissions', []);
        $role->syncPermissions($permissionIds);
        return redirect()->route('roles.index')->with('success', 'Rôle mis à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Rôle supprimé.');
    }
}
