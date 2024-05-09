<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Observation;
use App\Models\Order;
use App\Models\User;
use App\Models\Year;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Utils\OrderUtils;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $currentYear = Carbon::now()->year;
        $getCurrentYear = Year::where('year', $currentYear)->first();

        $client = new Client;
        $client->name = $request->name;
        $client->last_name = $request->last_name;
        $client->phone_number = $request->phone_number;
        $client->direction = $request->direction;
        $client->postal_code = $request->postal_code;
        $client->save();

        $order = new Order;
        $order->client_id = $client->id;
        $order->portions = $request->portions;
        $order->take_away = $request->take_away;
        $order->year_id = $getCurrentYear->id;
        if ($request->assign_order) {
            $order->user_id = Auth::user()->id;
        }
        $order->save();

        if (env('APP_EVENTO') == 'pastelitos') {
            setPriceAccordingToParametersCupcakes($order);
        } else {
            setPriceAccordingToParameters($order);
        }
        $this->setSauceAmount($order);

        if($request->observation != null) {
            $observation = new Observation;
            $observation->client_id = $client->id;
            $observation->year_id = $getCurrentYear->id;
            $observation->observation = $request->observation;
            $observation->save();
        }

    }

    public function update(Request $request, $id, $field)
    {
        $columnName = null;
        if ($field == 'portions') {
            $columnName = 'cantidades';
        }
        if ($field == 'take_away') {
            $columnName = 'delivery';
        }

        if ($field == 'money_collected') {
            $columnName = 'cobro';
        }

        if ($field == 'mp') {
            $columnName = 'forma de pago';
        }

        $order = Order::find($id);

        // Si hay diferencias entre la columna de mi orden y el dato que quiero entonces efectuo el cambio
        if ($order->$field != $request->input($field)) {
            $order->update([
                $field => $request->input($field),
                'last_edition' => Auth::user()->name . ' -Actualizo ' . $columnName . '-',
            ]);

            if($field == 'portions') {
                if (env('APP_EVENTO') == 'pastelitos') {
                    setPriceAccordingToParametersCupcakes($order);
                } else {
                    setPriceAccordingToParameters($order);
                }
                $this->calculateToCollect($order);
                $this->setSauceAmount($order);
            }

            if($field == 'money_collected') {
                $this->calculateToCollect($order);
            }
    
            $transformedOrder = OrderUtils::getOrderArray($order);
            return response()->json(['message' => 'Orden actualizada con éxito', 'order' => $transformedOrder]);
        } 

        // Si la info que recibo es igual a la que ya esta guarda no hago nada
        else {
            $transformedOrder = OrderUtils::getOrderArray($order);
            return response()->json(['message' => 'La orden no tuvo modificaciones', 'order' => $transformedOrder]);
        }
    }

    public function addObservation(Request $request, $order_id)
    {
        $order = Order::find($order_id);

        if ($request->observation != '') {
            $currentYear = Carbon::now()->year;

            $year = Year::where('year', $currentYear)->first();

            Observation::create([
                'client_id'   => $order->client->id,
                'year_id'     => $year->id,
                'observation' => $request->observation . "<br> (" . Carbon::now()->format("d-m-Y") . ")",
            ]);
    
            $order->update([
                'last_edition' => Auth::user()->name . ' -Agrego una observación-',
            ]);
    
            $transformedOrder = OrderUtils::getOrderArray($order);
    
            return response()->json(['message' => 'Orden actualizada con éxito', 'order' => $transformedOrder]);
        }
        $transformedOrder = OrderUtils::getOrderArray($order);
        return response()->json(['message' => 'Orden actualizada con éxito', 'order' => $transformedOrder]);
    }


    public function deleteObservation($order_id, $observation_id)
    {
        $order = Order::find($order_id);
        $observation = Observation::find($observation_id);
        $observation->delete();
        $order->update([
            'last_edition' => Auth::user()->name . ' -Elimino una observación-',
        ]);
        $transformedOrder = OrderUtils::getOrderArray($order);
        return response()->json(['message' => 'Orden actualizada con éxito', 'order' => $transformedOrder]);
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

    public function calculateToCollect(Order $order)
    {  
        $amount = $order->amount;
        $money_collected = $order->money_collected;

        $calculation = $amount - $money_collected;
        $order->to_collect = $calculation;
        $order->save();
    }

    public function destroy($id)
    {
        $order = Order::find($id);
        $order->delete();
    }

    public function assignMeOrder($order_id) {
        $authUserId = Auth::user()->id;
        $order = Order::find($order_id);
        $order->user_id = $authUserId;
        $order->save();
    }

    public function assignOrders(Request $request)
    {
        $orders_id = $request->input('ordersID');
        $rover_id = $request->input('roverID');

        $orders = Order::whereIn('id', $orders_id)->get();
        $rover = User::find($rover_id);

        foreach ($orders as $order) {
            $order->user_id = $rover->id;
            $order->save();
        }
    }
}
