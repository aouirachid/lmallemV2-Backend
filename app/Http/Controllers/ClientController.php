<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Models\Role;

class ClientController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('view client,api'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('create client,api'), only: ['store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('update client,api'), only: ['update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('delete client,api'), only: ['destroy']),
        ];
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $client = Client::with(['user', 'user.roles'])->get();
        return response()->json($client);
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
            'name' => 'required',
            'type' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users',
            'city' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required',
            'denomination' => 'nullable',
            'rc' => 'nullable',
            'ice' => 'nullable',
            'status' => 'required',
            'role' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'type' => $request->type,
            'phone' => $request->phone,
            'email' => $request->email,
            'city' => $request->city,
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);
        $role = Role::findById($request->role);
        $user->syncRoles($role);

        // $imagePath = $request->hasFile('image')
        // ? $request->file('image')->store('admin_images', 'public')
        // : null;  // Or use a default image path if needed


        //$imagePath = $request->file('image')->store('admin_images', 'public');

        $client = Client::create([
            // 'imagePath' => $imagePath,
            'denomination' => $request->denomination,
            'rc'  => $request->rc,
            'ice' => $request->ice,
            'status' => $request->status,
            'user_id' => $user->id,
        ]);

        return response()->json(['message' => 'Client created successfully', 'data' => $client]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $client = Client::with(['user', 'user.roles'])->findOrFail($id);
        $roles = Role::all(); // Get all available roles
        return response()->json([
            'client' => $client,
            'allRoles' => $roles
        ]);
    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users,email,' . $client->user_id,
            'city' => 'required',
            'username' => 'required|unique:users,username,' . $client->user_id,
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'denomination' => 'nullable',
            'rc' => 'nullable',
            'ice' => 'nullable',
            'status' => 'required',
            'role' => 'required|exists:roles,id',
        ]);

        $client->user->update([
            'name' => $request->name,
            'type' => $request->type,
            'phone' => $request->phone,
            'email' => $request->email,
            'city' => $request->city,
            'username' => $request->username,
            'password' => $request->password ? bcrypt($request->password) : $client->user->password,
        ]);

        // Update role
        $role = Role::findById($request->role);
        $client->user->syncRoles([$role]);

        // if ($request->hasFile('image')) {
        //     Storage::disk('public')->delete($client->imagePath);
        //     $imagePath = $request->file('image')->store('admin_images', 'public');
        //     $client->imagePath = $imagePath;
        // }

        $client->update([
            'denomination' => $request->denomination,
            'rc'  => $request->rc,
            'ice' => $request->ice,
            'status' => $request->status,
        ]);
        // $client->save();

        return response()->json(['message' => 'Client updated successfully', 'data' => $client]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        // Storage::disk('public')->delete($client->imagePath);
        $client->user->delete();
        $client->delete();

        return response()->json(['message' => 'Client deleted successfully']);
    }
}
