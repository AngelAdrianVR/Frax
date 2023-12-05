<?php

namespace App\Http\Controllers;

use App\Http\Resources\FavoriteGuestResource;
use App\Http\Resources\GuestResource;
use App\Models\FavoriteGuest;
use App\Models\Guest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GuestController extends Controller
{
    
    public function index()
    {
        $guests = GuestResource::collection(Guest::with('media')->latest()->get());

        // return $guests;

        return inertia('Guest/Index', compact('guests'));
    }

    
    public function create()
    {
        $favorite_guests = FavoriteGuestResource::collection(FavoriteGuest::with('media')->latest()->get());

        // return $favorite_guests;

        return inertia('Guest/Create', compact('favorite_guests'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'guest_type' => 'required|string',
            'name' => 'required|string|max:50',
            'visit_date' => 'required|date|after:yesterday',
            'time' => 'nullable',
            'identification' => 'nullable|boolean',
            'notes' => 'nullable|string|max:190',
            'vehicle_details.*' => $request->type == 'Vehicular' ? 'required' : 'nullable',
        ]);

        // Convierte el campo 'time' a un objeto Carbon y resta 6 horas
        $time = Carbon::parse($request->time)->subHours(6);

       $extra_data = [
        "user_id" => auth()->id(),
        "time" => $time,
        "qr_code" => $request->qr_code //generado en el mounted de la vista.
       ];
        
        $guest = Guest::create($request->except('time') + $extra_data);

        // Subir y asociar la imagen de visitante a la colección 'guest_images'
        if ($request->hasFile('guest_image')) {
            $guestImagePath = $request->file('guest_image')->store('guest_images', 'public');
            $guest->addMedia(storage_path('app/public/' . $guestImagePath))
                ->toMediaCollection('guest_images');
        }

        // Subir y asociar la imagen del vehículo a la colección 'vehicle_images'
        if ($request->hasFile('vehicle_image')) {
            $vehicleImagePath = $request->file('vehicle_image')->store('vehicle_images', 'public');
            $guest->addMedia(storage_path('app/public/' . $vehicleImagePath))
                ->toMediaCollection('vehicle_images');
        }

        //si se selecciona como visita frecuente
        if ($request->is_favorite_guest) {
            FavoriteGuest::create([
                'guest_type' => $request->gueguest_type,
                'name' => $request->name,
                'identification' => $request->identification,
                'notes' => $request->notes,
                'vehicle_details' => [$request->vehicle_details],
                'user_id' => auth()->id(),
            ]);
        }

        return to_route('guests.index');

    }

    
    public function show(Guest $guest)
    {
        //
    }

    
    public function edit($guest_id)
    {
        $guest = Guest::with('media')->find($guest_id);
        $favorite_guests = FavoriteGuestResource::collection(FavoriteGuest::with('media')->latest()->get());

        // return $guest;

        return inertia('Guest/Edit', compact('guest', 'favorite_guests'));
    }

    
    public function update(Request $request, Guest $guest)
    {
        $request->validate([
            'type' => 'required|string',
            'guest_type' => 'required|string',
            'name' => 'required|string|max:50',
            'visit_date' => 'required|date|after:yesterday',
            'time' => 'nullable',
            'identification' => 'nullable|boolean',
            'notes' => 'nullable|string|max:190',
            'vehicle_details.*' => $request->type == 'Vehicular' ? 'required' : 'nullable',
        ]);

        // Convierte el campo 'time' a un objeto Carbon y resta 6 horas
        $time = Carbon::parse($request->time)->subHours(6);

       $extra_data = [
        "time" => $time,
       ];
        
        $guest->update($request->except('time') + $extra_data);

        //si se selecciona como visita frecuente
        if ($request->is_favorite_guest) {
            FavoriteGuest::create([
                'guest_type' => $request->gueguest_type,
                'name' => $request->name,
                'identification' => $request->identification,
                'notes' => $request->notes,
                'vehicle_details' => [$request->vehicle_details],
                'user_id' => auth()->id(),
            ]);
        }

      return to_route('guests.index');

    }

    public function updateWithMedia(Request $request, Guest $guest)
    {
        $request->validate([
            'type' => 'required|string',
            'guest_type' => 'required|string',
            'name' => 'required|string|max:50',
            'visit_date' => 'required|date|after:yesterday',
            'time' => 'nullable',
            'identification' => 'nullable|boolean',
            'notes' => 'nullable|string|max:190',
            'vehicle_details.*' => $request->type == 'Vehicular' ? 'required' : 'nullable',
        ]);

        // Convierte el campo 'time' a un objeto Carbon y resta 6 horas
        $time = Carbon::parse($request->time)->subHours(6);

       $extra_data = [
        "time" => $time,
       ];
        
        $guest->update($request->except('time') + $extra_data);

         // media
         $guest->clearMediaCollection();
         
          // Subir y asociar la imagen de visitante a la colección 'guest_images'
        if ($request->hasFile('guest_image')) {
            $guestImagePath = $request->file('guest_image')->store('guest_images', 'public');
            $guest->addMedia(storage_path('app/public/' . $guestImagePath))
                ->toMediaCollection('guest_images');
        }

        // Subir y asociar la imagen del vehículo a la colección 'vehicle_images'
        if ($request->hasFile('vehicle_image')) {
            $vehicleImagePath = $request->file('vehicle_image')->store('vehicle_images', 'public');
            $guest->addMedia(storage_path('app/public/' . $vehicleImagePath))
                ->toMediaCollection('vehicle_images');
        }

        //si se selecciona como visita frecuente
        if ($request->is_favorite_guest) {
            FavoriteGuest::create([
                'guest_type' => $request->gueguest_type,
                'name' => $request->name,
                'identification' => $request->identification,
                'notes' => $request->notes,
                'vehicle_details' => [$request->vehicle_details],
                'user_id' => auth()->id(),
            ]);
        }

      return to_route('guests.index');
    }

   
    public function destroy(Guest $guest)
    {
        $guest->clearMediaCollection();
        $guest->delete();

        return response()->json(['item' => $guest]);
    }
}
