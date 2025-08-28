<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function member() {
        return $this->belongsTo(Member::class);
    }
    public function branch() {
        return $this->belongsTo(Branch::class);
    }
    public function invoice() {
        return $this->belongsTo(Invoice::class);
    }
    public function items() {
        return $this->hasMany(PaymentItem::class);
    }
    public function logs() {
        return $this->hasMany(PaymentLog::class);
    }
}
