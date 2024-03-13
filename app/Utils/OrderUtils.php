<?php

namespace App\Utils;

use Carbon\Carbon;
use App\Models\Year;

class OrderUtils
{
    public static function getOrderArray($order)
    {
        $currentYear = Carbon::now()->year;
        $year = Year::where('year', $currentYear)->first();

        $clientObservations = $order->client->observations
        ->where('year_id', $year->id)
        ->sortByDesc('id')
        ->values();

        // Si no hay observaciones para el año actual, obtén las del año pasado
        if ($clientObservations->isEmpty()) {
            $lastYear = Year::where('year', $currentYear - 1)->first();

            if(!$lastYear) {
                $lastYear = Year::create([
                    'year' => $currentYear - 1,
                    'active' => 0
                ]);
            }

            $clientObservations = $order->client->observations
                ->where('year_id', $lastYear->id)
                ->sortByDesc('id')
                ->values();
        }

        return [
            'id'              => $order->id,
            'client_id'       => $order->client->id,
            'year_id'         => $order->year->id,
            'user_id'         => $order->user ? $order->user->id : null,
            'portions'        => $order->portions,
            'take_away'       => (bool)$order->take_away,
            'sauces'          => $order->sauces,
            'amount'          => $order->amount,
            'money_collected' => $order->money_collected,
            'to_collect'      => $order->to_collect,
            'mp'              => (bool)$order->mp,
            'last_edition'    => $order->last_edition,
            'updated_at'      => Carbon::parse($order->updated_at)->format('d-m-y'),

            'client_id'           => $order->client->id,
            'name'                => $order->client->name,
            'last_name'           => $order->client->last_name,
            'phone_number'        => $order->client->phone_number,
            'direction'           => $order->client->direction,
            'postal_code'         => $order->client->postal_code,
            'user_name'           => $order->user ? $order->user->name : null,
            'client_observations' => $clientObservations
        ];
    }
}
