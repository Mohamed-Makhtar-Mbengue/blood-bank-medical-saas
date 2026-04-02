<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Http\Requests\StoreBloodInventoryRequest;
use App\Services\BloodInventoryService;

class InventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::orderBy('blood_type')->get();

        return view('inventory.index', compact('inventories'));
    }

    public function create()
    {
        return view('inventory.create');
    }

    public function store(StoreBloodInventoryRequest $request, BloodInventoryService $service)
    {
        $service->addStock($request->validated());

        return redirect()
            ->route('inventory.index')
            ->with('success', 'Poche de sang ajoutée avec succès.');
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();

        return redirect()->route('inventory.index')
            ->with('success', 'Poche supprimée avec succès.');
    }
    
    public function show($id)
    {
        $inventory = Inventory::findOrFail($id);

        return view('inventory.show', compact('inventory'));
    }

}
