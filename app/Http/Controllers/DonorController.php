<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use Illuminate\Http\Request;

class DonorController extends Controller
{
    public function index(Request $request)
    {
        $donors = Donor::query()
            ->when($request->name, fn($q) =>
                $q->where('name', 'like', '%' . $request->name . '%')
            )
            ->when($request->blood_type, fn($q) =>
                $q->where('blood_type', $request->blood_type)
            )
            ->when($request->city, fn($q) =>
                $q->where('city', 'like', '%' . $request->city . '%')
            )
            ->when($request->eligible === 'yes', fn($q) =>
                $q->where(function ($q) {
                    $q->whereNull('last_donation_date')
                    ->orWhereDate('last_donation_date', '<=', now()->subDays(56));
                })
            )
            ->when($request->eligible === 'no', fn($q) =>
                $q->whereDate('last_donation_date', '>', now()->subDays(56))
            )
            ->orderBy('name')
            ->paginate(10);

        return view('donors.index', compact('donors'));
    }

    public function create()
    {
        return view('donors.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
        'name'        => 'required|string|max:255',
        'email'       => 'required|email|max:255',
        'phone'       => 'required|string|max:20',
        'birth_date'  => 'required|date',
        'blood_type'  => 'required|string',
        'address'     => 'required|string|max:255',
        'city'        => 'required|string|max:255',
        'postal_code' => 'required|string|max:20',
    ]);

        Donor::create($data);

        return redirect()->route('donors.index')
            ->with('success', 'Donneur ajouté avec succès.');
    }

    public function destroy(Donor $donor)
    {
        $donor->delete();

        return redirect()->route('donors.index')
            ->with('success', 'Donneur supprimé.');
    }

    public function show(Donor $donor)
    {
        return view('donors.show', compact('donor'));
    }

}
