<?php

namespace App\Exports;

use App\Models\Branch;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BranchesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Branch::select('name','address')->get();
    }

    public function headings(): array
    {
        return ['Nama', 'Alamat'];
    }
}
