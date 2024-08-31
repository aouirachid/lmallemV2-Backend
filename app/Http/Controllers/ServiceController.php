<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Service::select('id','name','image','description','status','category_id')->get();
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
            'name' => 'required|string',
            'image' => 'required|string',
            'description' => 'required|string',
            'status' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);
        Service::create($request->all());
        return response()->json(['message' => 'Service created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return response()->json(['service'=>$service]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string',
            'image' => 'required|string',
            'description' => 'required|string',
            'status' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);
        $service->update($request->all());
        return response()->json(['message' => 'Service updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return response()->json(['message' => 'Service deleted successfully']);
    }
}
