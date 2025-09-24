<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $permissions = Permission::all();

        return view('permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
        ]);

        $permissions = Permission::create(['name' => $request->name]);
        return redirect()->route('permissions.index', $permissions)->with('success', 'Permission créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permissions)
    {
        return view('permissions.show', compact('permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permissions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permissions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permissions)
    {
        //
    }
}
