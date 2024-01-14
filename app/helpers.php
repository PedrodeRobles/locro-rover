<?php

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