<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'code',
        'member_id',
        'branch_id',
        'gross_amount_cents',
        'status',
        'midtrans_order_id',
        'midtrans_transaction_id',
        'payment_type',
        'fraud_status',
        'paid_at',
        'raw_request',
        'raw_notification',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function member() {
        return $this->belongsTo(Member::class);
    }
    public function branch() {
        return $this->belongsTo(Branch::class);
    }
    // public function invoice() {
    //     return $this->belongsTo(Invoice::class);
    // }
    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'payment_items', 'payment_id', 'invoice_id');
    }
    public function items() {
        return $this->hasMany(PaymentItem::class);
    }
    public function logs() {
        return $this->hasMany(PaymentLog::class);
    }
}
