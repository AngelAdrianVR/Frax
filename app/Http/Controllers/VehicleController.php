<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{

    public function index()
    {
        $vehicles = Vehicle::with('media')->get();

        return response()->json(['items' => $vehicles]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand' => 'required|string|max:255',
            'plate' => 'required|string|max:10',
            'color' => 'required|string|max:255',
            'notes' => 'nullable|string|max:255',
        ]);

        $vehicle = Vehicle::create($request->all() + ['user_id' => auth()->id()]);

        if ($request->hasFile('image')) {
            $vehicle->addMedia($request->image)->toMediaCollection();
        }

        return response()->json(['item' => $vehicle->load('media')]);
    }

    public function show(Vehicle $vehicle)
    {
        //
    }

    public function edit(Vehicle $vehicle)
    {
        //
    }

    public function updateWithMedia(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'brand' => 'required|string|max:255',
            'plate' => 'required|string|max:10',
            'color' => 'required|string|max:255',
            'notes' => 'nullable|string|max:255',
        ]);

        $vehicle->update($request->all());

        if ($request->image == 'deleted' || $request->hasFile('image')) {
            $vehicle->clearMediaCollection();
        }
        if ($request->hasFile('image')) {
            $vehicle->addMedia($request->image)->toMediaCollection();
        }

        return response()->json(['item' => $vehicle->load('media')]);
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return response()->json(['item' => $vehicle]);
    }
}
