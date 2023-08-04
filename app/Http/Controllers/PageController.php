<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    public function home()
    {
        // $orders = Order::all();

        $orders = Order::limit(14)
        ->get()
        ->map(function($order) {
            return [
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

                // 'observations_client_id'   => $order->client->observations,
                // 'observation_year_id'     => 1,
                'client_observations' => $order->client->observations,
            ];
        });

        return Inertia::render('List',[
            'orders' => $orders
        ]);
    }
}
