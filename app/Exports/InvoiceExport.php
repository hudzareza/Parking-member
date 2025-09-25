<?php

namespace App\Exports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class InvoiceExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Invoice::with(['member.user','branch']);

        // filter sesuai yang ada di controller
        if (!empty($this->filters['branch_id'])) {
            $query->where('branch_id', $this->filters['branch_id']);
        }
        if (!empty($this->filters['month'])) {
            $query->whereMonth('period', $this->filters['month']);
        }
        if (!empty($this->filters['year'])) {
            $query->whereYear('period', $this->filters['year']);
        }
        if (!empty($this->filters['start_date']) && !empty($this->filters['end_date'])) {
            $query->whereBetween('period', [$this->filters['start_date'], $this->filters['end_date']]);
        }

        return $query->get();
    }

    public function map($invoice): array
    {
        return [
            $invoice->code,
            $invoice->member->user->name ?? '-',
            $invoice->branch->name ?? '-',
            $invoice->period->format('F Y'),
            number_format($invoice->amount_cents/100, 0, ',', '.'),
            ucfirst($invoice->status),
            $invoice->due_date?->format('d-m-Y'),
            $invoice->paid_at?->format('d-m-Y H:i'),
        ];
    }

    public function headings(): array
    {
        return [
            'Kode Invoice',
            'Member',
            'Cabang',
            'Periode',
            'Jumlah',
            'Status',
            'Jatuh Tempo',
            'Dibayar Pada',
        ];
    }
}
