<?php

namespace App\Utils;

use Carbon\Carbon;

class OrderUtils
{
    public static function getOrderArray($order)
    {
        return [
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
            'updated_at'      => Carbon::parse($order->updated_at)->format('d-m-y'),

            'client_id'         => $order->client->id,
            'client_name'       => $order->client->name,
            'client_last_name'  => $order->client->last_name,
            'client_phone_number' => $order->client->phone_number,
            'client_direction'  => $order->client->direction,
            'client_postal_code' => $order->client->postal_code,
            'user_name'         => $order->user ? $order->user->name : null,
            'client_observations' => $order->client->observations->sortByDesc('id')->values(),
        ];
    }
}
