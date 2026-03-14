<?php

namespace App\Services;

use App\Models\BloodInventory;
use App\Services\BloodInventoryService;
use Exception;

class EmergencyService
{
    /**
     * Vérifie le stock ET déduit automatiquement la quantité
     */
    public function checkInventory(string $bloodType, int $quantityNeeded): bool
    {
        // Vérifier le stock total disponible
        $available = BloodInventory::where('blood_type', $bloodType)
            ->where('expiration_date', '>', now())
            ->where('status', 'available')
            ->sum('quantity_ml');

        if ($available < $quantityNeeded) {
            throw new Exception("Stock insuffisant pour cette urgence.");
        }

        // Déduire le stock (FIFO)
        $this->deductStock($bloodType, $quantityNeeded);

        return true;
    }

    /**
     * Déduction réelle du stock (FIFO)
     */
    public function deductStock(string $bloodType, int $quantity)
    {
        $pockets = BloodInventory::where('blood_type', $bloodType)
            ->where('expiration_date', '>', now())
            ->where('status', 'available')
            ->orderBy('expiration_date', 'asc') // FIFO médical
            ->get();

        foreach ($pockets as $pocket) {
            if ($quantity <= 0) break;

            if ($pocket->quantity_ml > $quantity) {
                // Déduction partielle
                $pocket->quantity_ml -= $quantity;
                $pocket->save();
                $quantity = 0;
            } else {
                // La poche est entièrement utilisée
                $quantity -= $pocket->quantity_ml;
                $pocket->quantity_ml = 0;
                $pocket->status = 'used';
                $pocket->save();
            }
        }
    }
}
