<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Imports\ClientsImport;
use App\Models\Client;
use App\Models\Order;
use App\Models\Year;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use App\Utils\OrderUtils;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $clients = Client::orderBy('id', 'desc')
            ->where(function ($query) use ($request) {
                $query->where('last_name', 'LIKE', "%$request->search%")
                    ->orWhere('phone_number', 'LIKE', "%$request->search%")
                    ->orWhere('direction', 'LIKE', "%$request->search%")
                    ->orWhere('name', 'LIKE', "%$request->search%");
            })
            ->get();

        return Inertia::render('Client/Index', ['clients' => $clients]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Client/Form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientRequest $request)
    {
        $currentYear   = Carbon::now()->year;
        $actualYearDB  = Year::where('year', $currentYear)->first();

        $client = Client::create($request->validated());

        $order = new Order();
        $order->client_id = $client->id;
        $order->year_id   = $actualYearDB->id;
        $order->save();

        // return to_route('client.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return Inertia::render('Client/Form', ['client' => $client]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientRequest $request, Client $client)
    {
        $client->update($request->validated());

        // return to_route('client.create');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return to_route('client.index');
    }

    public function importView()
    {
        return Inertia::render('Client/Import'); 
    }

    public function importExcel(Request $request)
    {
        $file = $request->file('import_file');

        try {
            Excel::import(new ClientsImport, $file);
            generateOrders();
        } catch (\Exception $e) {
            info($e);
            return $e->getMessage();
        }
    }

    public function clientHasOrder($id)
    {
        $now = Carbon::now()->year;

        $clientHasOrder = Order::where('client_id', $id)
            ->whereHas('year', function ($query) use ($now) {
                $query->where('year', $now);
            })
            ->exists();

        return response()->json(['clientHasOrder' => $clientHasOrder]);
    }

    public function deleteClients()
    {
        $deleteClients = Client::onlyTrashed()->get();

        return Inertia::render('Client/Trash', ['clients' => $deleteClients]);
    }

    public function rollbackClient($id)
    {
        $client = Client::withTrashed()->find($id);
        $client->restore();
    }

    public function updateFromOrder(Request $request, $id, $field) 
    {
        $columnName = null;

        if ($field == 'name') {
            $columnName = 'nombre del cliente';
        }

        if ($field == 'last_name') {
            $columnName = 'apellido del cliente';
        }

        if ($field == 'phone_number') {
            $columnName = 'número del cliente';
        }

        if ($field == 'direction') {
            $columnName = 'dirección del cliente';
        }

        if ($field == 'postal_code') {
            $columnName = 'código postal del cliente';
        }

        $currentYear   = Carbon::now()->year;
        $actualYearDB  = Year::where('year', $currentYear)->first();

        $order = Order::find($id);

        $clientsOrders = Order::where('client_id', $order->client->id)
            ->where('year_id', $actualYearDB->id)
            ->get();

        // Si hay diferencias entre la columna de mi orden y el dato que quiero entonces efectuo el cambio
        if ($order->client->$field != $request->input($field)) {

            $order->client->update([
                $field => $request->input($field)
            ]);

            foreach ($clientsOrders as $clientOrder) {
                $clientOrder->update([
                    'last_edition' => Auth::user()->name . ' -Actualizo ' . $columnName . '-',
                ]);
            }
            $order = Order::find($id);

            $transformedOrder = OrderUtils::getOrderArray($order);
            return response()->json(['message' => 'Orden actualizada con éxito', 'order' => $transformedOrder]);
        } 

        // Si la info que recibo es igual a la que ya esta guarda no hago nada
        else {
            $transformedOrder = OrderUtils::getOrderArray($order);
            return response()->json(['message' => 'La orden no tuvo modificaciones', 'order' => $transformedOrder]);
        }
    }
}
