<?php

namespace App\Http\Controllers;

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
}
