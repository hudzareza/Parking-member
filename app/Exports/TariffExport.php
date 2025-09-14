<?php

namespace App\Exports;

use App\Models\Tariff;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TariffExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Tariff::with('branch')
            ->orderBy('effective_start', 'desc')
            ->get()
            ->map(function ($t) {
                return [
                    'branch'          => optional($t->branch)->name ?? 'Pusat',
                    'vehicle_type'    => ucfirst($t->vehicle_type),
                    'amount'          => number_format($t->amount_cents / 100, 2, ',', '.'),
                    'effective_start' => $t->effective_start->format('Y-m-d'),
                ];
            });
    }

    public function headings(): array
    {
        return ['Cabang', 'Jenis Kendaraan', 'Tarif (Rp)', 'Berlaku Mulai'];
    }
}
