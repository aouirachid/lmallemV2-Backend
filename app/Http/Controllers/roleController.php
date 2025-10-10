<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class roleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('view role,api'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('create role,api'), only: ['store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('update role,api'), only: ['update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('delete role,api'), only: ['destroy']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('Add permission to role,api'), only: ['addPermissionToRole']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Role::select('id', 'name')->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required', 'string', 'uniqe:roles,name',
        ]);
        Role::create(['name' => $request->name]);

        return response()->json(['message' => 'Role created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return response()->json(['role' => $role]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($role) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required', 'string',
        ]);

        // $book->fill($request->post())->update();
        $role->update($request->all());

        return response()->json(['message' => 'Role updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json(['message' => 'role deleted successfully']);
    }

    public function addPermissionToRole(Request $request, Role $role, $roleId)
    {
        // Log incoming data for debugging
        //Log::info('Request Data:', $request->all());
        // Validate the request
        $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        // Assign permissions to the role
        $role = Role::findById($roleId);
        $role->syncPermissions($request->permissions);

        return response()->json(['message' => 'Permissions assigned successfully'], 200);
    }

    public function getRolesWithPermissions()
    {
        return Role::with('permissions')->get();
    }
}
