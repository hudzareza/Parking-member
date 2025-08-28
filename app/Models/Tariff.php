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
    ];

    protected $casts = [
        'effective_start' => 'date',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Ambil tarif aktif sesuai cabang, jenis kendaraan, dan tanggal
     */
    public function scopeActiveFor($query, $branchId, $vehicleType, $date = null)
    {
        $date = $date ?? now();

        return $query->where(function($q) use ($branchId) {
                $q->where('branch_id', $branchId)
                  ->orWhereNull('branch_id'); // fallback global
            })
            ->where('vehicle_type', $vehicleType)
            ->where('effective_start', '<=', $date)
            ->orderByRaw("CASE WHEN branch_id IS NULL THEN 0 ELSE 1 END DESC") // prioritaskan cabang
            ->orderBy('effective_start', 'desc');
    }

    public function scopeActive($query, $branchId, $date = null)
    {
        $date = $date ?? now();
        return $query->where(function($q) use ($branchId) {
                $q->whereNull('branch_id')->orWhere('branch_id', $branchId);
            })
            ->where('start_date', '<=', $date)
            ->where(function($q) use ($date) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', $date);
            });
    }
}
