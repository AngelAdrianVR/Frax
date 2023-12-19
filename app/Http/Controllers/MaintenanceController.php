<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenances = Maintenance::select('id', 'name', 'status')
            ->with('media')
            ->withCount('comments')
            ->where('status', '!=', 3)
            ->get();

        return inertia('Maintenance/Index', compact('maintenances'));
    }

    public function create()
    {
        return inertia('Maintenance/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:400',
            'location' => 'required|string|max:255',
            'is_anonymous_report' => 'boolean'
        ]);

        $maintenance = Maintenance::create($validated + ['user_id' => auth()->id()]);
        // Subir y asociar la imagen
        $maintenance->addAllMediaFromRequest()->each(fn ($file) => $file->toMediaCollection());

        return to_route('maintenances.index');
    }

    public function show(Maintenance $maintenance)
    {
        $maintenance = $maintenance->load(['media', 'user']);
        return inertia('Maintenance/Show', compact('maintenance'));
    }

    public function edit(Maintenance $maintenance)
    {
        //
    }

    public function update(Request $request, Maintenance $maintenance)
    {
        //
    }

    public function destroy(Maintenance $maintenance)
    {
        //
    }
}
