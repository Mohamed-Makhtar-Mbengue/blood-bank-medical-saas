<?php

namespace App\Http\Controllers;

use App\Models\EmergencyRequest;
use App\Models\Inventory;
use App\Http\Requests\StoreEmergencyRequest;
use App\Enums\EmergencyLevel;
use App\Services\EmergencyService;
use Illuminate\Support\Facades\DB;

class EmergencyController extends Controller
{
    public function __construct(private EmergencyService $service) {}

    public function index()
    {
        // Liste paginée
        $emergencies = EmergencyRequest::with('requester')
            ->orderByDesc('emergency_level')
            ->orderByDesc('created_at')
            ->paginate(10);

        // Statistiques
        $totalEmergencies = EmergencyRequest::count();

        $emergenciesThisMonth = EmergencyRequest::whereMonth('created_at', now()->month)->count();

        $emergenciesByType = EmergencyRequest::select('emergency_level', DB::raw('COUNT(*) as total'))
            ->groupBy('emergency_level')
            ->get();

        $emergenciesByMonth = EmergencyRequest::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('emergencies.index', compact(
            'emergencies',
            'totalEmergencies',
            'emergenciesThisMonth',
            'emergenciesByType',
            'emergenciesByMonth'
        ));
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

        try {
            $emergency = EmergencyRequest::create($data);

            $this->service->checkInventory(
                $emergency->blood_type->value,
                $emergency->quantity_ml
            );

        } catch (\Exception $e) {
            return back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()
            ->route('emergencies.show', $emergency)
            ->with('success', 'Urgence enregistrée et stock mis à jour.');
    }

    public function show(EmergencyRequest $emergency)
    {
        $availableBlood = Inventory::where('blood_type', $emergency->blood_type)
            ->where('expiration_date', '>', now())
            ->sum('quantity_ml');

        return view('emergencies.show', compact('emergency', 'availableBlood'));
    }

    public function destroy(EmergencyRequest $emergency)
    {
        $emergency->delete();

        return redirect()
            ->route('emergencies.index')
            ->with('success', 'Demande supprimée avec succès.');
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
