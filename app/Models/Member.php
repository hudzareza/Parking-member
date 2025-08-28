<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'branch_id',
        'phone',
        'id_card_number',
        'joined_at',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function branch() {
        return $this->belongsTo(Branch::class);
    }
    public function vehicles() {
        return $this->hasMany(Vehicle::class);
    }
    public function invoices() {
        return $this->hasMany(Invoice::class);
    }
    public function payments() {
        return $this->hasMany(Payment::class);
    }
}
