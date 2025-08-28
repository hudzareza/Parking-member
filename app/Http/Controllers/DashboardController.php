<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Vehicle;
use App\Models\Invoice;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMembers = Member::count();
        $totalVehicles = Vehicle::count();
        $invoicesThisMonth = Invoice::whereMonth('period', now()->month)
                                    ->whereYear('period', now()->year)
                                    ->count();

        return view('dashboard', compact('totalMembers', 'totalVehicles', 'invoicesThisMonth'));
    }
}
