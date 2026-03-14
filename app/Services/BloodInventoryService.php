<?php

namespace App\Services;

use App\Models\BloodInventory;
use Carbon\Carbon;

class BloodInventoryService
{
    /**
     * Ajouter une poche de sang au stock
     */
    public function addStock(array $data): BloodInventory
    {
        // Vérifier si une poche identique existe déjà
        $existing = BloodInventory::where('blood_type', $data['blood_type'])
            ->whereDate('expiration_date', $data['expiration_date'])
            ->where('status', 'available') // on fusionne seulement les poches disponibles
            ->first();

        if ($existing) {
            // Additionner les quantités
            $existing->quantity_ml += $data['quantity_ml'];

            // Mettre à jour le donation_id si fourni
            if (!empty($data['donation_id'])) {
                $existing->donation_id = $data['donation_id'];
            }

            $existing->save();

            return $existing;
        }

        // Sinon créer une nouvelle poche
        return BloodInventory::create([
            'blood_type'      => $data['blood_type'],
            'quantity_ml'     => $data['quantity_ml'],
            'expiration_date' => $data['expiration_date'],
            'donation_id'     => $data['donation_id'] ?? null,
            'status'          => 'available',
        ]);
    }


    /**
     * Déduire du stock (utilisé lors d'une urgence)
     */
    public function consumeStock(string $bloodType, int $amount): bool
    {
        $inventory = BloodInventory::where('blood_type', $bloodType)
            ->where('status', 'available')
            ->orderBy('expiration_date', 'asc') // FIFO médical
            ->first();

        if (!$inventory || $inventory->quantity_ml < $amount) {
            return false;
        }

        $inventory->quantity_ml -= $amount;

        if ($inventory->quantity_ml === 0) {
            $inventory->status = 'used';
        }

        $inventory->save();

        return true;
    }

    /**
     * Vérifier si une poche est expirée
     */
    public function markExpired()
    {
        BloodInventory::where('expiration_date', '<', Carbon::today())
            ->where('status', 'available')
            ->update(['status' => 'expired']);
    }
}
