<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Invoice;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $query = Invoice::where('proof_status', 'pending');

            // pastikan ada user yang login
            if (auth()->check() && auth()->user()->hasRole('cabang')) {
                $query->where('branch_id', auth()->user()->branch_id);
            }

            $pendingProofCount = $query->count();
            $view->with('pendingProofCount', $pendingProofCount);
        });
    }
}
