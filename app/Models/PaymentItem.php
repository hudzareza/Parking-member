<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentItem extends Model
{
    public function payment() {
        return $this->belongsTo(Payment::class);
    }
    public function invoice() {
        return $this->belongsTo(Invoice::class);
    }
}
