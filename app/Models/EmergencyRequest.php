<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\BloodType;
use App\Enums\EmergencyLevel;

class EmergencyRequest extends Model
{
    protected $fillable = [
        'patient_name',
        'blood_type',
        'quantity_ml',
        'emergency_level',
        'hospital_details',
        'notes',
        'requested_by',
        'status',
        'completed_at',
    ];

    protected $casts = [
        'blood_type' => BloodType::class,
        'emergency_level' => EmergencyLevel::class,
        'completed_at' => 'datetime',
    ];
    public function hasEnoughStock()
    {
        return \App\Models\BloodInventory::where('blood_type', $this->blood_type)
            ->sum('quantity_ml') >= $this->quantity_ml;
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isFulfilled(): bool
    {
        return $this->status === 'fulfilled';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'fulfilled';
    }

}
