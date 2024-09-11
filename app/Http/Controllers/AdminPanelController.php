<?php

namespace App\Http\Controllers;

use App\Models\adminPanel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class AdminPanelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $adminPanels = AdminPanel::with(['user', 'user.roles']);
        // $roles = Role::all(); // Get all available roles
        // return response()->json([
        //     'adminPanels' => $adminPanels,
        //     'allRoles' => $roles
        // ]);
        $adminPanels = AdminPanel::with(['user', 'user.roles'])->get();
        return response()->json($adminPanels);
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
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

        $imagePath = $request->file('image')->store('admin_images', 'public');

        $adminPanel = AdminPanel::create([
            'imagePath' => $imagePath,
            'status' => $request->status,
            'user_id' => $user->id,
        ]);

        return response()->json(['message' => 'Admin panel created successfully', 'data' => $adminPanel]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $adminPanel = AdminPanel::with(['user', 'user.roles'])->findOrFail($id);
        $roles = Role::all(); // Get all available roles
        return response()->json([
            'adminPanel' => $adminPanel,
            'allRoles' => $roles
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(adminPanel $adminPanel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $adminPanel = AdminPanel::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users,email,' . $adminPanel->user_id,
            'city' => 'required',
            'username' => 'required|unique:users,username,' . $adminPanel->user_id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required',
            'role' => 'required|exists:roles,id',
        ]);

        $adminPanel->user->update([
            'name' => $request->name,
            'type' => $request->type,
            'phone' => $request->phone,
            'email' => $request->email,
            'city' => $request->city,
            'username' => $request->username,
        ]);

        // Update role
        $role = Role::findById($request->role);
        $adminPanel->user->syncRoles([$role]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($adminPanel->imagePath);
            $imagePath = $request->file('image')->store('admin_images', 'public');
            $adminPanel->imagePath = $imagePath;
        }

        $adminPanel->status = $request->status;
        $adminPanel->save();

        return response()->json(['message' => 'Admin panel updated successfully', 'data' => $adminPanel]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $adminPanel = AdminPanel::findOrFail($id);
        Storage::disk('public')->delete($adminPanel->imagePath);
        $adminPanel->user->delete();
        $adminPanel->delete();

        return response()->json(['message' => 'Admin panel deleted successfully']);
    }
}
