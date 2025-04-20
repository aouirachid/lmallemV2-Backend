<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order = Order::with(['client', 'handy_men', 'service', 'client.user', 'handy_men.user'])->get();
        return response()->json($order);
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
            'orderNumber' => 'required|string',
            'client_id' => 'required|exists:clients,id',
            'handy_men_id' => 'required|exists:handy_men,id',
            'service_id' => 'required|exists:services,id',
            'orderPrice' => 'required|numeric',
            'orderDescription' => 'required|string',
            'orderDate' => 'required|date',
            'orderDeliveredAt' => 'nullable|date',
            'orderStatus' => 'required|string',
            'orderLocation' => 'required|string',
        ]);
        Order::create([
            'orderNumber' => $request->orderNumber,
            'client_id' => $request->client_id,
            'handy_men_id' => $request->handy_men_id,
            'service_id' => $request->service_id,
            'orderPrice' => $request->orderPrice,
            'orderDescription' => $request->orderDescription,
            'orderDate' => $request->orderDate,
            'orderDelivredAt' => $request->orderDelivredAt,
            'orderStatus'  => $request->orderStatus,
            'orderLocation' => $request->orderLocation,
        ]);
        return response()->json(['message' => 'Order created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return response()->json(['order' => $order]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
