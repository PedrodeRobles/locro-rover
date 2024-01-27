<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Inertia\Inertia;
use App\Utils\OrderUtils;
use Carbon\Carbon;
use App\Models\Year;

class PageController extends Controller
{
    public function home()
    {
        $currentYear = Carbon::now()->year;
        $year = Year::where('year', $currentYear)->first();

        $orders = Order::where('year_id', $year->id)->get()
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

        $currentYear = Carbon::now()->year;
        $year = Year::where('year', $currentYear)->first();

        $orders = Order::where('user_id', $user_auth_id)
        ->where('year_id', $year->id)
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
