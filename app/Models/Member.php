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
        'portal_token',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($member) {
            if (empty($member->portal_token)) {
                $member->portal_token = \Illuminate\Support\Str::uuid()->toString();
            }
        });
    }

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
