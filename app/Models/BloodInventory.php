<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloodInventory extends Model
{
    protected $fillable = [
        'blood_type',
        'quantity_ml',
        'expiration_date',
        'donation_id',
        'status',
    ];

    protected $casts = [
        'expiration_date' => 'date',
    ];

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }
}
