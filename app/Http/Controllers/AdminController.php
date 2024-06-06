<?php

namespace App\Http\Controllers;

use App\Exports\OrdersExport;
use App\Models\Parameter;
use App\Models\Order;
use App\Models\User;
use App\Models\Year;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Index');
    }

    public function years()
    {
        $years = Year::orderBy('year', 'desc')->get();

        $thisYearExists = Year::where('year', Carbon::now()->year)->exists();

        return Inertia::render('Admin/Years', [
            'years' => $years,
            'thisYearExists' => $thisYearExists,
        ]);
    }

    public function createThisYear()
    {
        $thisYear = Carbon::now()->year;

        Year::create([
            'year' => $thisYear,
            'active' => true
        ]);

        $oldYears = Year::where('year', '!=', $thisYear)->get();

        foreach ($oldYears as $oldYear) {
            $oldYear->update(['active' => false]);
        }

        generateOrders();

        return to_route('admin.years'); 
    }

    public function parameters()
    {
        $currentYear = Carbon::now()->year;
        $getCurrentYear = Year::where('year', $currentYear)->first();

        if ($getCurrentYear !== null) {
            $parameter = Parameter::where('year_id', $getCurrentYear->id)->first();
        } else {
            abort(404);
        }

        return Inertia::render('Admin/Parameters', [
            'year' => $getCurrentYear,
            'parameter' => $parameter,
        ]);
    }

    public function storeParameters(Request $request)
    {
        $currentYear = Carbon::now()->year;
        $getCurrentYear = Year::where('year', $currentYear)->first();

        Parameter::create([
            'year_id'=> $getCurrentYear->id,
            'unit_price'=> $request->unit_price,
            'promo_unit_price' => $request->promo_unit_price,
            'amount_for_promo'=> $request->amount_for_promo,
        ]);

        return to_route('admin.parameters'); 
    }

    public function updateParameters(Request $request, Parameter $parameter)
    {
        $parameter->unit_price = $request->unit_price;
        $parameter->promo_unit_price = $request->promo_unit_price;
        $parameter->amount_for_promo = $request->amount_for_promo;
        $parameter->save();

        $currentYear = Carbon::now()->year;

        try {
            $orders = Order::whereHas('year', function ($query) use ($currentYear) {
                $query->where('year', $currentYear);
            })
            ->orderBy('id')
            ->get();
    
            foreach ($orders as $order) {
                if (env('APP_EVENTO') == 'pastelitos') {
                    setPriceAccordingToParametersCupcakes($order);
                } else {
                    setPriceAccordingToParameters($order);
                }
            }
        } catch (\Exception $e) {
            info($e);
            return $e->getMessage();
        }
    }

    public function exportOrders()
    {
        $currentYear = Carbon::now()->year;
        return Excel::download(new OrdersExport, 'ordenes-' . $currentYear . '.xlsx');
    }

    public function roles()
    {
        $roles = Role::all();
        $users = User::where('active', 1)->get()
            ->map(function($user) {
                return [
                    'id'    => $user->id,
                    'name'  => $user->name,
                    'roles' => $user->getRoleNames()
                ];
            });

        return Inertia::render('Admin/Roles', [
            'roles' => $roles,
            'users' => $users,
        ]);
    }

    public function assignRoles($user_id, $role_name)
    {
        $user = User::find($user_id);
        $role = Role::where('name', $role_name)->first();
        if ($user->hasRole($role_name)) {
            // Si el usuario ya tiene el rol asignado, elimina el rol
            $user->removeRole($role);
        } else {
            // Si el usuario no tiene el rol asignado, asigna el rol
            $user->assignRole($role);
        }
    }

    public function softDelete($user_id)
    {
        $user = User::find($user_id);
        $user->active = 0;
        $user->save();
    }

    public function softDeletedUsers()
    {
        $users = User::where('active', 0)->get()
        ->map(function($user) {
            return [
                'id'    => $user->id,
                'name'  => $user->name,
                'roles' => $user->getRoleNames()
            ];
        });

        return Inertia::render('Admin/SoftDeletedUsers', [
            'users' => $users,
        ]);
    }

    public function rollbackUser($user_id)
    {
        $user = User::find($user_id);
        $user->active = 1;
        $user->save();
    }

    public function difineMadePortions(Request $request)
    {
        $currentYear = Carbon::now()->year;
        $getCurrentYear = Year::where('year', $currentYear)->first();

        $getCurrentYear->made_portions = $request->madePortions;
        $getCurrentYear->save();
    }
}
