<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
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
