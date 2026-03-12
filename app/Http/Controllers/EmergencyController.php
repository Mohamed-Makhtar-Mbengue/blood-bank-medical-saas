<?php

namespace App\Http\Controllers;

use App\Models\EmergencyRequest;
use App\Models\BloodInventory;
use App\Http\Requests\StoreEmergencyRequest;
use App\Enums\EmergencyLevel;
use App\Services\EmergencyService;

class EmergencyController extends Controller
{
    public function __construct(private EmergencyService $service) {}

    public function index()
    {
        $emergencies = EmergencyRequest::with('requester')
            ->orderByDesc('emergency_level')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('emergencies.index', compact('emergencies'));
    }

    public function create()
    {
        return view('emergencies.create', [
            'emergencyLevels' => EmergencyLevel::cases(),
        ]);
    }

    public function store(StoreEmergencyRequest $request)
    {
        $data = $request->validated();
        $data['requested_by'] = null;

        $emergency = EmergencyRequest::create($data);

        $this->service->checkInventory(
            $emergency->blood_type->value,
            $emergency->quantity_ml
        );

        return redirect()
            ->route('emergencies.show', $emergency)
            ->with('success', 'Demande d\'urgence enregistrée avec succès !');
    }

    public function show(EmergencyRequest $emergency)
    {
        $availableBlood = BloodInventory::where('blood_type', $emergency->blood_type)
            ->where('expiration_date', '>', now())
            ->sum('quantity_ml');

        return view('emergencies.show', compact('emergency', 'availableBlood'));
    }

    public function complete(EmergencyRequest $emergency)
    {
        $emergency->update([
            'status' => 'fulfilled',
            'completed_at' => now(),
        ]);

        return back()->with('success', 'Demande d\'urgence marquée comme complétée !');
    }
}
