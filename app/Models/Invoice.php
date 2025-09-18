<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
      protected $fillable = [
        'code',
        'member_id',
        'branch_id',
        'vehicle_id',
        'period',
        'amount_cents',
        'status',
        'due_date',
        'paid_at',
        'proof_file',
        'proof_status',
        'verification_note',
        'verified_by',
        'proof_uploaded_at',
        'verified_at',
    ];

    protected $casts = [
        'period'   => 'date',
        'due_date' => 'date',
        'paid_at'  => 'datetime',
        'proof_uploaded_at' => 'datetime',
        'verified_at'       => 'datetime',
    ];


    public function vehicle() {
        return $this->belongsTo(Vehicle::class);
    }

    public function member() {
        return $this->belongsTo(Member::class);
    }
    public function branch() {
        return $this->belongsTo(Branch::class);
    }
    public function paymentItems() {
        return $this->hasMany(PaymentItem::class);
    }
}
