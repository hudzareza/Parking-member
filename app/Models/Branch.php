<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use HasFactory;

    // Izinkan mass-assignment untuk kolom name & address
    protected $fillable = [
        'name',
        'address',
        'code',
    ];

    public function users() {
        return $this->hasMany(User::class);
    }
    public function members() {
        return $this->hasMany(Member::class);
    }
    public function invoices() {
        return $this->hasMany(Invoice::class);
    }
    public function payments() {
        return $this->hasMany(Payment::class);
    }
}
