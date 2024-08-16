<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Permission::select('id','name')->get();
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
            'name' => 'required','string','uniqe:permissions,name'
        ]);
        Permission::create(['name' => $request->name]);
        return response()->json(['message' => 'Book created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        return response()->json(['permission' => $permission]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($permission)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required','string'
        ]);

        
        // $book->fill($request->post())->update();
        $permission->update($request->all());
        return response()->json(['message' => 'Book updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return response()->json(['message' => 'permission deleted successfully']);
    }
}
