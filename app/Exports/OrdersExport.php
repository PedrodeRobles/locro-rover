<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Models\Year;
use Carbon\Carbon;

class OrdersExport implements FromView
{
    /**
    * @return \Illuminate\Support\View
    */
    public function view(): View 
    {
        $currentYear = Carbon::now()->year;
        $getCurrentYear = Year::where('year', $currentYear)->first();
        $getPrevioustYear = Year::where('year', $currentYear - 1)->first();

        return view('export-orders', [
            'orders' => Order::where('year_id', $getCurrentYear->id)
                            ->with('user')
                            ->with('client')
                            ->get(),
            'getCurrentYear' => $getCurrentYear,
            'getPrevioustYear' => $getPrevioustYear ? $getPrevioustYear : null,
        ]);
    }
}
