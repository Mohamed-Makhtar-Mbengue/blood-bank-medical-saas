<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventory extends Model
{
    use HasFactory;
    protected $table = 'blood_inventories';
    
    protected $fillable = [
        'blood_type',
        'quantity_ml',
        'expiration_date',
        'status',
    ];

    protected $casts = [
    'expiration_date' => 'datetime',
    ];


    // Alerte : stock faible
    public function isLowStock()
    {
        return $this->quantity_ml < 150;
    }

    // Alerte : expiration proche (moins de 3 jours)
    public function isExpiringSoon()
    {
        return $this->expiration_date->isBefore(now()->addDays(3));
    }
}
