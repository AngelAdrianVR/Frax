<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{

    public function index()
    {
        $pets = Pet::with('media')->get();

        return response()->json(['items' => $pets]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:10',
            'race' => 'required|string|max:255',
            'notes' => 'nullable|string|max:255',
        ]);

        $pet = Pet::create($request->all() + ['user_id' => auth()->id()]);

        if ($request->hasFile('image')) {
            $pet->addMedia($request->image)->toMediaCollection();
        }

        return response()->json(['item' => $pet->load('media')]);
    }

    public function show(Pet $pet)
    {
        //
    }

    public function edit(Pet $pet)
    {
        //
    }

    public function updateWithMedia(Request $request, Pet $pet)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:10',
            'race' => 'required|string|max:255',
            'notes' => 'nullable|string|max:255',
        ]);

        $pet->update($request->all());

        if ($request->image == 'deleted' || $request->hasFile('image')) {
            $pet->clearMediaCollection();
        }
        if ($request->hasFile('image')) {
            $pet->addMedia($request->image)->toMediaCollection();
        }

        return response()->json(['item' => $pet->load('media')]);
    }

    public function destroy(Pet $pet)
    {
        $pet->delete();

        return response()->json(['item' => $pet]);
    }
}
