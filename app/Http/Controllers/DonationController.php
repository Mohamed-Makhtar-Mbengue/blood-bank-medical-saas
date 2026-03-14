<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Donor;
use App\Services\BloodInventoryService;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index(Request $request)
    {
        $donations = Donation::query()
            ->when($request->blood_type, fn($q) =>
                $q->where('blood_type', $request->blood_type)
            )
            ->when($request->status, fn($q) =>
                $q->where('status', $request->status)
            )
            ->when($request->date, fn($q) =>
                $q->whereDate('donation_date', $request->date)
            )
            ->with('donor')
            ->orderBy('donation_date', 'desc')
            ->paginate(10);

        return view('donations.index', compact('donations'));
    }

    public function create()
    {
        $donors = Donor::orderBy('name')->get()->map(function ($donor) {
            return [
                'id' => $donor->id,
                'name' => $donor->name,
                'blood_type' => $donor->blood_type->value,
                'eligible' => $donor->canDonate(),
                'days_left' => $donor->last_donation_date
                    ? max(0, 56 - $donor->last_donation_date->diffInDays(now()))
                    : 0,
            ];
        });

        return view('donations.create', compact('donors'));
    }


    public function store(Request $request, BloodInventoryService $service)
    {
        $data = $request->validate([
            'donor_id'      => 'required|exists:donors,id',
            'blood_type'    => 'required|string',
            'quantity_ml'   => 'required|integer|min:1',
            'donation_date' => 'required|date',
            'notes'         => 'nullable|string',
        ]);

        $donor = Donor::findOrFail($data['donor_id']);

        if (!$donor->canDonate()) {
            return back()->withErrors([
                'donor_id' => 'Ce donneur ne peut pas encore donner (56 jours requis).'
            ]);
        }

        $donation = Donation::create([
            'donor_id'      => $donor->id,
            'blood_type'    => $data['blood_type'],
            'quantity_ml'   => $data['quantity_ml'],
            'donation_date' => $data['donation_date'],
            'notes'         => $data['notes'] ?? null,
            'status'        => 'completed',
        ]);

        $donor->update([
            'last_donation_date' => $data['donation_date']
        ]);

        $service->addStock([
            'blood_type'      => $data['blood_type'],
            'quantity_ml'     => $data['quantity_ml'],
            'expiration_date' => now()->addDays(42),
            'donation_id'     => $donation->id,
        ]);

        return redirect()->route('donations.index')
            ->with('success', 'Donation enregistrée et stock mis à jour.');
    }

    public function destroy(Donation $donation)
    {
        $donation->delete();

        return redirect()->route('donations.index')
            ->with('success', 'Donation supprimée.');
    }
    public function show(Donation $donation)
    {
        return view('donations.show', compact('donation'));
    }
}
