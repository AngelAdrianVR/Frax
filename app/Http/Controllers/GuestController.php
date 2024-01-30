<?php

namespace App\Http\Controllers;

use App\Http\Resources\FavoriteGuestResource;
use App\Http\Resources\GuestResource;
use App\Models\FavoriteGuest;
use App\Models\Guest;
use App\Models\GuestHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GuestController extends Controller
{
    
    public function index()
    {
        $guests = GuestResource::collection(Guest::with('media')->latest()->where('user_id', auth()->id())->get());

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

        // Guardar el archivo en la colección 'guest_images'
        if ($request->hasFile('guest_image')) {
            $guest->addMediaFromRequest('guest_image')->toMediaCollection('guest_images');
        }

        // Guardar el archivo en la colección 'vehicle_image'
        if ($request->hasFile('vehicle_image')) {
            $guest->addMediaFromRequest('vehicle_image')->toMediaCollection('vehicle_images');
        }

        //historial de visitas
        GuestHistory::create([
            'name' => $guest->name,
            'date' => $guest->visit_date,
            'time' => $guest->time,
            'type_access' => $request->guest_type, //tomado del request porque el tipo de acceso no se guarda en la tabla de guets
            'qr_code' => $guest->qr_code,
            'notes' => $guest->notes,
            'guest_reference_id' => $guest->id,
            'user_id' => auth()->id(),
        ]);

        //si se selecciona como visita frecuente
        if ($request->is_favorite_guest) {
            $favorite_guest = FavoriteGuest::create([
                'guest_type' => $request->gueguest_type,
                'name' => $request->name,
                'identification' => $request->identification,
                'notes' => $request->notes,
                'vehicle_details' => [$request->vehicle_details],
                'user_id' => auth()->id(),
            ]);

            // Guardar el archivo en la colección 'guest_images'
        if ($request->hasFile('guest_image')) {
                $favorite_guest->addMediaFromRequest('guest_image')->toMediaCollection('guest_images');
            }
            
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

        // media ---------------------------------------------------
        // Eliminar imágenes antiguas solo si se borró desde el input y no se agregó una nueva
        if ($request->guestImageCleared) {
            $guest->clearMediaCollection('guest_images');
        }

        if ($request->vehicleImageCleared) {
            $guest->clearMediaCollection('vehicle_images');
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
        // Eliminar imágenes antiguas solo si se borró desde el input y no se agregó una nueva
        if ($request->guestImageCleared) {
            $guest->clearMediaCollection('guest_images');
        }

        if ($request->vehicleImageCleared) {
            $guest->clearMediaCollection('vehicle_images');
        }

         // Eliminar imágenes antiguas solo si se proporcionan nuevas imágenes
         if ($request->hasFile('guest_image')) {
            $guest->clearMediaCollection('guest_images');
        }

        if ($request->hasFile('vehicle_image')) {
            $guest->clearMediaCollection('vehicle_images');
        }

         // Guardar el archivo en la colección 'guest_images'
         if ($request->hasFile('guest_image')) {
            $guest->addMediaFromRequest('guest_image')->toMediaCollection('guest_images');
        }

        // Guardar el archivo en la colección 'vehicle_image'
        if ($request->hasFile('vehicle_image')) {
            $guest->addMediaFromRequest('vehicle_image')->toMediaCollection('vehicle_images');
        }

        //si se selecciona como visita frecuente
        if ($request->is_favorite_guest) {
            $favorite_guest = FavoriteGuest::create([
                'guest_type' => $request->gueguest_type,
                'name' => $request->name,
                'identification' => $request->identification,
                'notes' => $request->notes,
                'vehicle_details' => [$request->vehicle_details],
                'user_id' => auth()->id(),
            ]);

            // Guardar el archivo en la colección 'guest_images'
         if ($request->hasFile('guest_image')) {
            $favorite_guest->addMediaFromRequest('guest_image')->toMediaCollection('guest_images');
        }

        // Guardar el archivo en la colección 'vehicle_image'
        if ($request->hasFile('vehicle_image')) {
            $favorite_guest->addMediaFromRequest('vehicle_image')->toMediaCollection('vehicle_images');
        }
        }

      return to_route('guests.index');
    }

   
    public function destroy(Guest $guest)
    {
        $guest->clearMediaCollection();
        $guest_history = GuestHistory::where('guest_reference_id', $guest->id)->first(); //busca el historial de la visita programada a eliminar
        $guest_history->delete(); //Elimina el registro de historial para que no se muestren los que se eliminaron.
        $guest->delete();

        return response()->json(['item' => $guest]);
    }
}
