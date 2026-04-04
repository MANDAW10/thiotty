<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Broadcast;

class AlertController extends Controller
{
    public function index()
    {
        $alerts = Broadcast::latest()->paginate(10);
        return view('admin.alerts.index', compact('alerts'));
    }

    public function create()
    {
        return view('admin.alerts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:info,warning,success',
        ]);

        Broadcast::create($request->all());

        return redirect()->route('admin.alerts.index')->with('success', 'Alerte créée.');
    }

    public function toggle(Broadcast $alert)
    {
        $alert->update(['is_active' => !$alert->is_active]);
        return back()->with('success', 'Statut de l\'alerte mis à jour.');
    }

    public function destroy(Broadcast $alert)
    {
        $alert->delete();
        return redirect()->route('admin.alerts.index')->with('success', 'Alerte supprimée.');
    }
}
