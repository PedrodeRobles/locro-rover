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
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
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
    public function update(Request $request, $id, $field)
    {
        $order = Order::find($id);
        $order->update([
            $field => $request->input($field),
        ]);

        $transformedOrder = [
            'id'              => $order->id,
            'client_id'       => $order->client->id,
            'year_id'         => $order->year->id,
            'user_id'         => $order->user ? $order->user->id : null,
            'portions'        => $order->portions,
            'take_away'       => $order->take_away,
            'sauces'          => $order->sauces,
            'amount'          => $order->amount,
            'money_collected' => $order->money_collected,
            'to_collect'      => $order->to_collect,
            'mp'              => $order->mp,
            'last_edition'    => $order->last_edition,
            'client_name'         => $order->client->name,
            'client_last_name'    => $order->client->last_name,
            'client_phone_number' => $order->client->phone_number,
            'client_direction'    => $order->client->direction,
            'client_postal_code'  => $order->client->postal_code,
            'user_name'         => $order->user ? $order->user->name : null,
            'client_observations' => $order->client->observations,
        ];
    
        // Devuelve los datos transformados
        return response()->json(['message' => 'Orden actualizada con éxito', 'order' => $transformedOrder]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
