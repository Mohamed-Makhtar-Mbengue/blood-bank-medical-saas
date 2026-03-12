<?php

namespace App\Services;

use App\Models\BloodInventory;

class EmergencyService
{
    public function checkInventory(string $bloodType, int $quantityNeeded): bool
    {
        $available = BloodInventory::where('blood_type', $bloodType)
            ->where('expiration_date', '>', now())
            ->sum('quantity_ml');

        return $available >= $quantityNeeded;
    }

    public function deductStock(string $bloodType, int $quantity)
    {
        // TODO: logique de déduction du stock
    }
}
