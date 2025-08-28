<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\InvoiceService;

class GenerateInvoices extends Command
{
    protected $signature = 'invoices:generate {--month=} {--year=}';
    protected $description = 'Generate monthly invoices for all members';

    public function handle(InvoiceService $service)
    {
        $month = $this->option('month') ?? now()->month;
        $year  = $this->option('year') ?? now()->year;

        $service->generateForPeriod($year, $month);

        $this->info("Invoices generated for {$month}/{$year}");
    }
}
