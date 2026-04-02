<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Donor;
use App\Models\Donation;
use App\Models\EmergencyRequest;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index()
    {
        // Stock par groupe sanguin
        $stockByType = Inventory::select('blood_type', DB::raw('SUM(quantity_ml) as total'))
            ->groupBy('blood_type')
            ->orderBy('blood_type')
            ->get();

        // Statuts
        $statusCounts = Inventory::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();

        // Dons par mois (12 derniers mois)
        $donationsByMonth = Donation::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Urgences par mois
        $emergenciesByMonth = EmergencyRequest::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Donneurs
        $donors = Donor::count();

        return view('statistics.index', compact(
            'stockByType',
            'statusCounts',
            'donationsByMonth',
            'emergenciesByMonth',
            'donors'
        ));
    }
}
