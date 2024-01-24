<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Inertia\Inertia;
use App\Utils\OrderUtils;

class PageController extends Controller
{
    public function home()
    {
        $orders = Order::all()
        ->map(function($order) {
            return OrderUtils::getOrderArray($order);
        })
        ->sortBy('id');

        return Inertia::render('List',[
            'orders' => $orders
        ]);
    }

    public function myList()
    {
        if(auth()->check()) {
            $user_auth_id = auth()->user()->id;
        } else {
            return response("Tenes que estar logeado papu: 404" ,404);
        }

        $orders = Order::where('user_id', $user_auth_id)
        ->get()
        ->map(function($order) {
            return OrderUtils::getOrderArray($order);
        })
        ->sortBy('id');

        return Inertia::render('List',[
            'orders' => $orders,
            'user_auth_name' => auth()->user()->name,
        ]);
    }
}
