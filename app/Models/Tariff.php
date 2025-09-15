<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tariff extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'vehicle_type',
        'amount_cents',
        'effective_start',
        'effective_end',
    ];

    protected $casts = [
        'effective_start' => 'date',
        'effective_end'   => 'date',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Ambil tarif aktif sesuai cabang, jenis kendaraan, dan tanggal.
     */
    public function scopeActiveFor($query, $branchId, $vehicleType, $date = null)
    {
        $date = $date ?? now();

        return $query->where('vehicle_type', $vehicleType)
            ->where(function ($q) use ($branchId) {
                $q->where('branch_id', $branchId)
                  ->orWhereNull('branch_id'); // fallback global
            })
            ->where(function ($q) use ($date) {
                $q->whereNull('effective_start')
                  ->orWhere('effective_start', '<=', $date);
            })
            ->where(function ($q) use ($date) {
                $q->whereNull('effective_end')
                  ->orWhere('effective_end', '>=', $date);
            })
            ->orderByRaw("CASE WHEN branch_id IS NULL THEN 0 ELSE 1 END DESC") // prioritaskan cabang
            ->orderBy('effective_start', 'desc');
    }
}

