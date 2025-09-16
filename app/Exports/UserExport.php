<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return User::with('branch')
            ->get()
            ->map(function($user) {
                return [
                    'name' => $user->name,
                    'email' => $user->email,
                    'branch_name' => optional($user->branch)->name,
                ];
            });
    }

    public function headings(): array
    {
        return ['Nama', 'Email', 'Lokasi'];
    }
}
