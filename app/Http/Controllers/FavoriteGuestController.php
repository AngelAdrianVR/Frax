<?php

namespace App\Http\Controllers;

use App\Http\Resources\FavoriteGuestResource;
use App\Http\Resources\GuestResource;
use App\Models\FavoriteGuest;
use App\Models\Guest;
use Illuminate\Http\Request;

class FavoriteGuestController extends Controller
{
    
    public function index()
    {
        //
    }

    
    public function create()
    {
        return inertia('FavoriteGuest/Create');
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'guest_type' => 'required|string',
            'name' => 'required|string|max:50',
            'identification' => 'boolean',
            'notes' => 'nullable|string|max:190',
            'vehicle_details' => 'nullable|array',
        ]);

        $favorite_guest = FavoriteGuest::create($validated + ['user_id' => auth()->id()]);

        // Subir y asociar la imagen de visitante a la colección 'guest_images'
        if ($request->hasFile('guest_image')) {
            $guestImagePath = $request->file('guest_image')->store('guest_images', 'public');
            $favorite_guest->addMedia(storage_path('app/public/' . $guestImagePath))
                ->toMediaCollection('guest_image');
        }

        if (isset($request->vehicle_details)) {

            foreach ($request->vehicle_details as $vehicle) {
                if (isset($vehicle['image'])) {
                    // Subir y asociar la imagen del vehículo a la colección 'vehicle_images'
                    $vehicleImagePath = $vehicle['image']->store('vehicle_images', 'public');
                    
                    // Asegúrate de asociar la imagen al vehículo actual
                    $favorite_guest->addMedia(storage_path('app/public/' . $vehicleImagePath))
                    ->toMediaCollection('vehicle_images');
                    
                }
            }
        }
            
        return to_route('guests.index', ['currentTab' => 2]);
    }

    
    public function show(FavoriteGuest $favorite_guest)
    {
        //
    }

    
    public function edit($favorite_guest_id)
    {
        $favorite_guest = FavoriteGuest::with('media')->find($favorite_guest_id);

        // return $favorite_guest;

        return inertia('FavoriteGuest/Edit', compact('favorite_guest'));
    }

    
    public function update(Request $request, FavoriteGuest $favorite_guest)
    {
        
        $validated = $request->validate([
            'guest_type' => 'required|string',
            'name' => 'required|string|max:50',
            'identification' => 'boolean',
            'notes' => 'nullable|string|max:190',
            'vehicle_details' => 'nullable|array',
        ]);

        $favorite_guest->update($validated);

        return to_route('guests.index', ['currentTab' => 2]);
    }


    public function updateWithMedia(Request $request, FavoriteGuest $favorite_guest)
    {
        
        $validated = $request->validate([
            'guest_type' => 'required|string',
            'name' => 'required|string|max:50',
            'identification' => 'boolean',
            'notes' => 'nullable|string|max:190',
            'vehicle_details' => 'nullable|array',
        ]);

        $favorite_guest->update($validated);

         // media
         $favorite_guest->clearMediaCollection();

          // Subir y asociar la imagen de visitante a la colección 'guest_images'
        if ($request->hasFile('guest_image')) {
            $guestImagePath = $request->file('guest_image')->store('guest_images', 'public');
            $favorite_guest->addMedia(storage_path('app/public/' . $guestImagePath))
                ->toMediaCollection('guest_image');
        }

        foreach ($request->vehicle_details as $vehicle) {
            if (isset($vehicle['image'])) {
                // Subir y asociar la imagen del vehículo a la colección 'vehicle_images'
                $vehicleImagePath = $vehicle['image']->store('vehicle_images', 'public');
                
                // Asegúrate de asociar la imagen al vehículo actual
                $favorite_guest->addMedia(storage_path('app/public/' . $vehicleImagePath))
                    ->toMediaCollection('vehicle_images');
                
            }
        }

        return to_route('guests.index', ['currentTab' => 2]);
    }

    
    public function destroy(FavoriteGuest $favorite_guest)
    {
        $favorite_guest->clearMediaCollection();
        $favorite_guest->delete();

        return response()->json(['item' => $favorite_guest]);
    }

    public function getAll()
    {
        $favorite_guests = FavoriteGuestResource::collection(FavoriteGuest::with('media')->where('user_id', auth()->id())->get());

        return response()->json(['items' => $favorite_guests]);
    }
}
