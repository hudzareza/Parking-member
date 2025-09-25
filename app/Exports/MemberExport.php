<?php

namespace App\Exports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MemberExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Member::with(['user','branch']);

        if (!empty($this->filters['branch_id'])) {
            $query->where('branch_id', $this->filters['branch_id']);
        }
        if (!empty($this->filters['month'])) {
            $query->whereMonth('joined_at', $this->filters['month']);
        }
        if (!empty($this->filters['year'])) {
            $query->whereYear('joined_at', $this->filters['year']);
        }
        if (!empty($this->filters['start_date']) && !empty($this->filters['end_date'])) {
            $query->whereBetween('joined_at', [$this->filters['start_date'], $this->filters['end_date']]);
        }

        return $query->get();
    }

    public function map($member): array
    {
        return [
            $member->user->name ?? '-',
            $member->user->email ?? '-',
            $member->branch->name ?? '-',
            $member->phone ?? '-',
            $member->joined_at?->format('d-m-Y'),
        ];
    }

    public function headings(): array
    {
        return ['Nama', 'Email', 'Cabang', 'Telepon', 'Tanggal Bergabung'];
    }
}
