<?php

namespace App\Http\Controllers;

use App\Models\Observation;
use App\Models\Order;
use App\Models\Year;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Utils\OrderUtils;

class OrderController extends Controller
{
    public function update(Request $request, $id, $field)
    {
        $order = Order::find($id);
        $order->update([
            $field => $request->input($field),
            'last_edition' => Auth::user()->name,
        ]);

        setPriceAccordingToParameters($order);

        if($field == 'portions') {
            $this->setSauceAmount($order);
        }

        $transformedOrder = OrderUtils::getOrderArray($order);
    
        // Devuelve los datos transformados
        return response()->json(['message' => 'Orden actualizada con éxito', 'order' => $transformedOrder]);
    }

    public function addObservation(Request $request, $order_id)
    {
        $currentYear = Carbon::now()->year;

        $year = Year::where('year', $currentYear)->first();

        $order = Order::find($order_id);

        Observation::create([
            'client_id'   => $order->client->id,
            'year_id'     => $year->id,
            'observation' => $request->observation . ' (' . $year->year . ')',
        ]);

        $order->update([
            'last_edition' => Auth::user()->name,
        ]);

        $transformedOrder = OrderUtils::getOrderArray($order);

        return response()->json(['message' => 'Orden actualizada con éxito', 'order' => $transformedOrder]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    public function setSauceAmount(Order $order)
    {
        // Obtengo el resto de la cantidad de porciones entre 2
        //con esto determino si la cantidad de porciones son par o impar
        $res = $order->portions % 2;

        //La cantidad de porciones es par
        if ($res == 0) {
            $div = $order->portions / 2;
            $order->sauces = $div;

        //La cantidad de porciones es impar
        } else {
            $pairPortionAmount = $order->portions - 1;
            $div = $pairPortionAmount / 2;
            $order->sauces = $div;
        }

        //Caso donde solo se pide una porción se le agrega una salsa
        if($order->portions == 1) {
            $order->sauces = 1;
        }

        $order->save();
    }
}
