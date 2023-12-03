<?php

namespace App\Http\Controllers;

use App\Http\Resources\GuestResource;
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
        return inertia('Guest/Create');
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
        "qr_code" => Str::random(10)  // Generar una cadena de texto aleatoria para el código QR
       ];
        
        $visit = Guest::create($request->except('time') + $extra_data);

        // Subir y asociar la imagen de visitante a la colección 'guest_images'
        if ($request->hasFile('guest_image')) {
            $guestImagePath = $request->file('guest_image')->store('guest_images', 'public');
            $visit->addMedia(storage_path('app/public/' . $guestImagePath))
                ->toMediaCollection('guest_images');
        }

        // Subir y asociar la imagen del vehículo a la colección 'vehicle_images'
        if ($request->hasFile('vehicle_image')) {
            $vehicleImagePath = $request->file('vehicle_image')->store('vehicle_images', 'public');
            $visit->addMedia(storage_path('app/public/' . $vehicleImagePath))
                ->toMediaCollection('vehicle_images');
        }

        return to_route('guests.index');

    }

    
    public function show(Guest $guest)
    {
        //
    }

    
    public function edit(Guest $guest)
    {
        return inertia('Guest/Edit', compact('guest'));
    }

    
    public function update(Request $request, Guest $guest)
    {
        //
    }

   
    public function destroy(Guest $guest)
    {
        $guest->clearMediaCollection();
        $guest->delete();

        return response()->json(['item' => $guest]);
    }
}
