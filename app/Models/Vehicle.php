<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'plate_number',
        'vehicle_type',
        'brand',
        'model',
    ];

    public function member() {
        return $this->belongsTo(Member::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
