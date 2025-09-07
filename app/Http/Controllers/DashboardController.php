<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Branch;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ==== Statistik member (sudah ada di kode kamu) ====
        $stats = Branch::withCount('members')->get();
        $labels = $stats->pluck('name');
        $data   = $stats->pluck('members_count');

        // ==== Statistik pertumbuhan member ====
        $months = collect();
        $membersGrowth = collect();

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months->push($month->format('M Y'));

            $count = \App\Models\Member::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            $membersGrowth->push($count);
        }

        // ==== Statistik pendapatan per cabang ====
        $revenueStats = Branch::withSum(['payments as revenue' => function ($q) {
            $q->whereNotNull('paid_at'); // hanya yang sudah dibayar
        }], 'gross_amount_cents')->get();

        $revenueLabels = $revenueStats->pluck('name');
        $revenueData   = $revenueStats->pluck('revenue');


        // ==== Statistik pendapatan per bulan (6 bulan terakhir) ====
        $revenueGrowth = collect();
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);

            $sum = Payment::whereYear('paid_at', $month->year)
                ->whereMonth('paid_at', $month->month)
                ->sum('gross_amount_cents');

            $revenueGrowth->push($sum);
        }

        return view('dashboard', [
            'labels'         => $labels,
            'data'           => $data,
            'stats'          => $stats,
            'months'         => $months,
            'membersGrowth'  => $membersGrowth,
            'revenueLabels'  => $revenueLabels,
            'revenueData'    => $revenueData,
            'revenueGrowth'  => $revenueGrowth, 
        ]);

    }
}
