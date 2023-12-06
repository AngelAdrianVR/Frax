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
        //
    }

    public function show(Maintenance $maintenance)
    {
        return $maintenance;
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
