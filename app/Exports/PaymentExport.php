<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PaymentExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Payment::with('invoices', 'member.user', 'branch');

        // filter percabang
        if (!empty($this->filters['branch_id'])) {
            $query->where('branch_id', $this->filters['branch_id']);
        }

        // filter bulan & tahun
        if (!empty($this->filters['month'])) {
            $query->whereMonth('paid_at', $this->filters['month']);
        }
        if (!empty($this->filters['year'])) {
            $query->whereYear('paid_at', $this->filters['year']);
        }

        // filter range tanggal
        if (!empty($this->filters['start_date']) && !empty($this->filters['end_date'])) {
            $query->whereBetween('paid_at', [$this->filters['start_date'], $this->filters['end_date']]);
        }

        return $query->get();
    }

    public function map($payment): array
    {
        return [
            $payment->code,
            $payment->invoices->pluck('code')->implode(', '),
            $payment->member->user->name ?? '-',
            $payment->branch->name ?? '-',
            'Rp ' . number_format($payment->gross_amount_cents/100, 0, ',', '.'),
            ucfirst($payment->status),
            $payment->paid_at?->format('d-m-Y H:i'),
        ];
    }

    public function headings(): array
    {
        return [
            'Kode Payment',
            'Invoice(s)',
            'Member',
            'Cabang',
            'Jumlah',
            'Status',
            'Tanggal Bayar'
        ];
    }
}
