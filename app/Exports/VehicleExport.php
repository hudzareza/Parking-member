<?php

namespace App\Exports;

use App\Models\Vehicle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VehicleExport implements FromCollection, WithHeadings
{
    protected $branchId;

    public function __construct($branchId = null)
    {
        $this->branchId = $branchId;
    }

    public function collection()
    {
        $query = Vehicle::with(['member.branch', 'member.user']);

        if ($this->branchId) {
            $query->whereHas('member', function ($q) {
                $q->where('branch_id', $this->branchId);
            });
        }

        return $query->get()->map(function ($v) {
            return [
                'plat_nomor' => $v->plate_number,
                'jenis'      => ucfirst($v->vehicle_type),
                'member'     => optional($v->member->user)->name,
                'cabang'     => optional($v->member->branch)->name,
            ];
        });
    }

    public function headings(): array
    {
        return ['Plat Nomor', 'Jenis Kendaraan', 'Member', 'Cabang'];
    }
}
