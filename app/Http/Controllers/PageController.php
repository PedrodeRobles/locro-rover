<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Inertia\Inertia;
use App\Utils\OrderUtils;
use Carbon\Carbon;
use App\Models\Year;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home(Request $request)
    {
        $currentYear = Carbon::now()->year;
        $year = Year::where('year', $currentYear)->first();

        $orders = Order::where('year_id', $year->id)
        ->where(function($query) use ($request) {
            if ($request->has('retirada') && ($request->retirada !== 'all')) {
                $query->where('withdrawal', $request->retirada)
                    ->where('portions', '>', 0);
            }
        })
        ->where(function($query) use ($request) {
            if ($request->has('mp') && ($request->mp !== 'all')) {
                if ($request->mp == 0) {
                    $query->where(function($q) {
                        $q->where('mp', 0)
                            ->orWhereNull('mp')
                            ->where('portions', '>', 0);
                    });
                } else {
                    $query->where('mp', $request->mp)
                        ->where('portions', '>', 0);
                }
            }
        })
        ->where(function($query) use ($request) {
            if ($request->has('delivery') && ($request->delivery !== 'all')) {
                if ($request->delivery == 0) {
                    $query->where(function($q) {
                        $q->where('take_away', 0)
                            ->orWhereNull('take_away')
                            ->where('portions', '>', 0);
                    });
                } else {
                    $query->where('take_away', $request->delivery)
                        ->where('portions', '>', 0);
                }

            }
        })
        ->where(function($query) use ($request) {
            if ($request->has('portionsFilter') && ($request->portionsFilter !== 'all')) {
                if ($request->portionsFilter == 1) {
                    $query->where('portions', '>', 0);
                } else {
                    $query->where('portions', 0)
                        ->orWhereNull('portions');
                }
            }
        })
        ->where(function($query) use ($request) {
            if ($request->has('search') && $request->search) {
                $query->whereHas('client', function($query) use ($request) {
                    $query->where(function ($q) use ($request) {
                        $q->where('last_name', 'LIKE', "%{$request->search}%")
                            ->orWhere('phone_number', 'LIKE', "%{$request->search}%")
                            ->orWhere('direction', 'LIKE', "%{$request->search}%")
                            ->orWhere('name', 'LIKE', "%{$request->search}%");
                    });
                })
                ->orWhereHas('user', function($query) use ($request) {
                    $query->where(function ($q) use ($request) {
                        $q->where('name', 'LIKE', "%{$request->search}%");
                    });
                });
            }
        })
        ->select('orders.*') // Seleccionamos todos los campos de la tabla orders
        ->orderByRaw(
            "(SELECT last_name FROM clients WHERE clients.id = orders.client_id) ASC"
        )
        ->get()
        ->map(function($order) {
            return OrderUtils::getOrderArray($order);
        });

        $rovers = User::where('active', 1)->orderBy('name')->get();

        return Inertia::render('List',[
            'orders' => $orders,
            'list_type' => 'general',
            'rovers' => $rovers,
            'currentYear' => $year,
        ]);
    }

    public function myList(Request $request)
    {
        if(auth()->check()) {
            $user_auth_id = auth()->user()->id;
        } else {
            return response("Tenes que estar logeado papu: 404" ,404);
        }

        $currentYear = Carbon::now()->year;
        $year = Year::where('year', $currentYear)->first();

        $orders = Order::where('year_id', $year->id)
        ->where('user_id', $user_auth_id)
        ->where(function($query) use ($request) {
            if ($request->has('withdrawal') && ($request->withdrawal !== 'all')) {
                $query->where('withdrawal', $request->withdrawal)
                    ->where('portions', '>', 0);
            }
        })
        ->where(function($query) use ($request) {
            if ($request->has('mp') && ($request->mp !== 'all')) {
                if ($request->mp == 0) {
                    $query->where(function($q) {
                        $q->where('mp', 0)
                            ->orWhereNull('mp');
                    });
                } else {
                    $query->where('mp', $request->mp);
                }
            }
        })
        ->where(function($query) use ($request) {
            if ($request->has('delivery') && ($request->delivery !== 'all')) {
                if ($request->delivery == 0) {
                    $query->where(function($q) {
                        $q->where('take_away', 0)
                            ->orWhereNull('take_away')
                            ->where('portions', '>', 0);
                    });
                } else {
                    $query->where('take_away', $request->delivery)
                        ->where('portions', '>', 0);
                }
            }
        })
        ->where(function($query) use ($request) {
            if ($request->has('portionsFilter') && ($request->portionsFilter !== 'all')) {
                if ($request->portionsFilter == 1) {
                    $query->where('portions', '>', 0);
                } else {
                    $query->where('portions', 0)
                        ->orWhereNull('portions');
                }
            }
        })
        ->where(function($query) use ($request) {
            if ($request->has('search') && $request->search) {
                $query->whereHas('client', function($query) use ($request) {
                    $query->where(function ($q) use ($request) {
                        $q->where('last_name', 'LIKE', "%{$request->search}%")
                            ->orWhere('phone_number', 'LIKE', "%{$request->search}%")
                            ->orWhere('direction', 'LIKE', "%{$request->search}%")
                            ->orWhere('name', 'LIKE', "%{$request->search}%");
                    });
                })
                ->orWhereHas('user', function($query) use ($request) {
                    $query->where(function ($q) use ($request) {
                        $q->where('name', 'LIKE', "%{$request->search}%");
                    });
                });
            }
        })
        ->select('orders.*') // Seleccionamos todos los campos de la tabla orders
        ->orderByRaw(
            "(SELECT last_name FROM clients WHERE clients.id = orders.client_id) ASC"
        )
        ->get()
        ->map(function($order) {
            return OrderUtils::getOrderArray($order);
        });

        $userHasOrders = Order::where('user_id', $user_auth_id)
            ->where('year_id', $year->id)
            ->exists();

        $rovers = User::where('active', 1)->orderBy('name')->get();


        return Inertia::render('List',[
            'orders'          => $orders,
            'user_auth_name'  => auth()->user()->name,
            'list_type'       => 'my_list',
            'user_has_orders' => $userHasOrders,
            'currentYear' => $year,
            'rovers' => $rovers,
        ]);
    }

    public function guest()
    {
        return Inertia::render('Guest'); 
    }

    public function statistics() 
    {
        $active_users = User::where('active', 1)
            ->with('orders')
            ->get()
            ->map(function ($user) {
                return [
                    'name' => $user->name,
                    'total_portions' => $user->total_portions,
                ];
            })
            ->sortByDesc('total_portions');

        return Inertia::render('Statistics', [
            'activeUsers' => $active_users->values()->toArray()
        ]); 
    }
}
