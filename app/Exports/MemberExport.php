<?php

namespace App\Exports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MemberExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Member::with(['user','branch','vehicles'])
            ->get()
            ->map(function ($member) {
                $vehicles = $member->vehicles->map(function ($v) {
                    return $v->vehicle_type.' - '.$v->plate_number;
                })->join(', ');

                return [
                    'name'      => $member->user->name,
                    'email'     => $member->user->email,
                    'phone'     => $member->phone,
                    'id_card'   => $member->id_card_number,
                    'branch'    => optional($member->branch)->name,
                    'joined_at' => $member->joined_at->format('Y-m-d'),
                    'vehicles'  => $vehicles ?: '-',
                ];
            });
    }

    public function headings(): array
    {
        return ['Nama', 'Email', 'Telepon', 'No KTP', 'Lokasi', 'Tanggal Bergabung', 'Kendaraan'];
    }
}
