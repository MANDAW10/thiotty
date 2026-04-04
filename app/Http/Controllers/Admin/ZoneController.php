<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\DeliveryZone;

class ZoneController extends Controller
{
    public function index()
    {
        $zones = DeliveryZone::all();
        return view('admin.zones.index', compact('zones'));
    }

    public function create()
    {
        return view('admin.zones.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'fee' => 'required|numeric|min:0',
        ]);

        DeliveryZone::create($request->all());

        return redirect()->route('admin.zones.index')->with('success', 'Zone de livraison ajoutée.');
    }

    public function edit(DeliveryZone $zone)
    {
        return view('admin.zones.edit', compact('zone'));
    }

    public function update(Request $request, DeliveryZone $zone)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'fee' => 'required|numeric|min:0',
        ]);

        $zone->update($request->all());

        return redirect()->route('admin.zones.index')->with('success', 'Zone mise à jour.');
    }

    public function destroy(DeliveryZone $zone)
    {
        $zone->delete();
        return redirect()->route('admin.zones.index')->with('success', 'Zone supprimée.');
    }
}
