<?php

use App\Models\Parameter;
use App\Models\Order;
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