<?php

use App\Http\Controllers\OrderController;
use App\Models\Client;
use App\Models\Parameter;
use App\Models\Order;
use App\Models\Year;
use Carbon\Carbon;

function setPriceAccordingToParameters(Order $order)
{
    $currentYear = Carbon::now()->year;

    $currentParameter = Parameter::whereHas('year', function ($query) use ($currentYear) {
        $query->where('year', $currentYear);
    })->first();

    if ($order->portions >= $currentParameter->amount_for_promo) {
        $order->amount = $currentParameter->promo_unit_price * $order->portions;
        $order->save();
    } else {
        $order->amount = $currentParameter->unit_price * $order->portions;
        $order->save();
    }
    $orderController = new OrderController;
    $orderController->calculateToCollect($order);
}

function generateOrders()
{
    $currentYear   = Carbon::now()->year;
    $actualYearDB  = Year::where('year', $currentYear)->first();

    $clients = Client::doesntHave('orders.year', 'and', function ($query) use ($currentYear) {
        $query->where('year', $currentYear);
    })->get();

    foreach ($clients as $client) {
        $order = new Order();
        $order->client_id = $client->id;
        $order->year_id   = $actualYearDB->id;
        $order->save();
    }
}

function setPriceAccordingToParametersCupcakes(Order $order)
{
    $currentYear = Carbon::now()->year;

    $currentParameter = Parameter::whereHas('year', function ($query) use ($currentYear) {
        $query->where('year', $currentYear);
    })->first();

    $isOdd = ($order->portions + $order->batata) % 2; // 0 es par 1 es impar

    if ($isOdd) {
        $docenas = floor(($order->portions + $order->batata) / 2); // 5 / 2 = 2.5 -> 2
        $precioPorDocenas = $docenas * $currentParameter->promo_unit_price;
        $precioTotal = $precioPorDocenas + $currentParameter->unit_price;
        $order->amount = $precioTotal;
        $order->save();
    } else {
        $docenas = ($order->portions + $order->batata) / 2;
        $precioPorDocenas = $docenas * $currentParameter->promo_unit_price;
        $order->amount = $precioPorDocenas;
        $order->save();
    }

    $orderController = new OrderController;
    $orderController->calculateToCollect($order);
}

function quantitySold()
{
    $currentYear = Carbon::now()->year;

    $countCurrentOrders = Order::whereHas('year', function ($query) use ($currentYear) {
        $query->where('year', $currentYear);
    })->select('portions', 'batata')  // Seleccionar solo las columnas necesarias
    ->get();

    $totalSum = $countCurrentOrders->sum(function($order) {
        return $order->portions + $order->batata;  // Sumar las columnas seleccionadas
    });

    if (env('APP_EVENTO') == 'pastelitos') {
        $totalSum = $totalSum / 2;
    }

    return $totalSum;
}