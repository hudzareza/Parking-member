<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PaymentExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Payment::select()->get();
    }

    public function headings(): array
    {
        return ['Invoice', 'Jumlah', 'Status', 'Dibayar di'];
    }
}
