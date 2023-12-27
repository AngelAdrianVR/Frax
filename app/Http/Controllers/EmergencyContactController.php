<?php

namespace App\Http\Controllers;

use App\Models\EmergencyContact;
use Illuminate\Http\Request;

class EmergencyContactController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:14',
            'relationship' => 'required|string|max:255',
        ]);

        $contact = EmergencyContact::create($request->all() + ['user_id' => auth()->id()]);

        if ($request->hasFile('image')) {
            $contact->addMedia($request->image)->toMediaCollection();
        }

        return response()->json(['item' => $contact->load('media')]);
    }

    public function show(EmergencyContact $emergencyContact)
    {
        //
    }

    public function edit(EmergencyContact $emergencyContact)
    {
        //
    }

    public function updateWithMedia(Request $request, EmergencyContact $emergencyContact)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:14',
            'relationship' => 'required|string|max:255',
        ]);

        $emergencyContact->update($request->all());

        if ($request->image == 'deleted' || $request->hasFile('image')) {
            $emergencyContact->clearMediaCollection();
        }
        if ($request->hasFile('image')) {
            $emergencyContact->addMedia($request->image)->toMediaCollection();
        }

        return response()->json(['item' => $emergencyContact->load('media')]);
    }

    public function destroy(EmergencyContact $emergencyContact)
    {
        $emergencyContact->delete();

        return response()->json(['item' => $emergencyContact]);
    }
}
