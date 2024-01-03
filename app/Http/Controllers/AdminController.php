<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
use App\Models\Order;
use App\Models\Year;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

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
                setPriceAccordingToParameters($order);
            }
            dd("Agregar mensaje de éxito");
        } catch (\Exception $e) {
            info($e);
            return $e->getMessage();
        }
    }
}
