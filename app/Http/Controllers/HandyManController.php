<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\handyMan;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class HandyManController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
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
            'ice' => 'required|unique:handy_men',
            'specializedField' => 'required',
            'accountNumber' => 'required|unique:handy_men',
            'bankName' => 'required',
            'selfEmployedCard' => 'required',
            'Anthropometric' => 'required',
            'diploma' => 'required',
            'status' => 'required',
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
        $handyMan = handyMan::create([
            'ice' => $request->ice,
            'specializedField' => $request->specializedField,
            'accountNumber' => $request->accountNumber,
            'bankName' => $request->bankName,
            'status' => $request->status,
            'user_id' => $user->id,
        ]);
        $selfEmployedCard = $request->hasFile('selfEmployedCard')
        ? $request->file('selfEmployedCard')->store('selfEmployedCards', 'public')
        : null;
        $Anthropometric = $request->hasFile('Anthropometric')
        ? $request->file('Anthropometric')->store('Anthropometrics', 'public')
        : null;
        $diploma = $request->hasFile('diploma')
        ? $request->file('diploma')->store('diploma', 'public')
        : null;
        Document::create([
            'selfEmployedCard' => $selfEmployedCard,
            'Anthropometric' => $Anthropometric,
            'diploma' => $diploma,
            'handy_man_id' => $handyMan->id,
        ]);
        return response()->json(['message' => 'HandyMan created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(handyMan $handyMan)
    {
        return response()->json(['data' => $handyMan]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(handyMan $handyMan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $handyMan = handyMan::findOrFail($id);

        // Validate request data
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users,email,' . $handyMan->user_id,
            'city' => 'required',
            'username' => 'required|unique:users,username,' . $handyMan->user_id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ice' => 'required|unique:handy_men,ice,' . $handyMan->id,
            'specializedField' => 'required',
            'accountNumber' => 'required|unique:handy_men,accountNumber,' . $handyMan->id,
            'bankName' => 'required',
            'selfEmployedCard' => 'nullable|file|mimes:jpeg,png,pdf',
            'Anthropometric' => 'nullable|file|mimes:jpeg,png,pdf',
            'diploma' => 'nullable|file|mimes:jpeg,png,pdf',
            'status' => 'required',
        ]);

        // Update user details
        $handyMan->user->update([
            'name' => $request->name,
            'type' => $request->type,
            'phone' => $request->phone,
            'email' => $request->email,
            'city' => $request->city,
            'username' => $request->username,
            'password' => $request->password ? bcrypt($request->password) : $handyMan->user->password,
        ]);

        // Update handyman details
        $handyMan->update([
            'ice' => $request->ice,
            'specializedField' => $request->specializedField,
            'accountNumber' => $request->accountNumber,
            'bankName' => $request->bankName,
            'status' => $request->status,
        ]);

        // Handle file uploads and update document
        $documentData = [];
        if ($request->hasFile('selfEmployedCard')) {
            $documentData['selfEmployedCard'] = $request->file('selfEmployedCard')->store('selfEmployedCards', 'public');
        }
        if ($request->hasFile('Anthropometric')) {
            $documentData['Anthropometric'] = $request->file('Anthropometric')->store('Anthropometrics', 'public');
        }
        if ($request->hasFile('diploma')) {
            $documentData['diploma'] = $request->file('diploma')->store('diplomas', 'public');
        }

        if (!empty($documentData)) {
            Document::updateOrCreate(
                ['handy_man_id' => $handyMan->id], // Match condition
                $documentData // Update or create with this data
            );
        }

        return response()->json(['message' => 'Handyman updated successfully']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $handyMan = handyMan::with('document')->findOrFail($id);

        // Delete files if they exist
        if ($handyMan->document) {
            if ($handyMan->document->selfEmployedCard) {
                Storage::disk('public')->delete($handyMan->document->selfEmployedCard);
            }
            if ($handyMan->document->Anthropometric) {
                Storage::disk('public')->delete($handyMan->document->Anthropometric);
            }
            if ($handyMan->document->diploma) {
                Storage::disk('public')->delete($handyMan->document->diploma);
            }
        }

        // Deleting the handyman will cascade delete related `document` and `user`
        $handyMan->delete();

        return response()->json(['message' => 'Handy Man deleted successfully']);
    }
}
