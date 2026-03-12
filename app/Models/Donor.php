<?php

namespace App\Models;

use App\Enums\BloodType;
use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'birth_date', 
        'blood_type', 'last_donation_date', 'address', 'city'
    ];

    protected $casts = [
        'blood_type' => BloodType::class,
        'last_donation_date' => 'date',
        'birth_date' => 'date',
    ];

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function canDonate(): bool
    {
        if (!$this->last_donation_date) {
            return true;
        }

        return $this->last_donation_date->diffInDays(now()) >= 56;
    }
}