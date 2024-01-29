<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommunityEventResource;
use App\Models\CommunityEvent;
use App\Models\CommunityEventUser;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CommunityEventController extends Controller
{
    
    public function index()
    {
        $community_events = CommunityEventResource::collection(CommunityEvent::latest()->with('media')->where('frax_id', auth()->user()->frax_id)->get());
        $my_community_events = CommunityEventUser::where('user_id', auth()->id())->get();

        // return $community_events;

        return inertia('CommunityEvent/Index', compact('community_events', 'my_community_events'));
    }

    
    public function create()
    {
        return inertia('CommunityEvent/Create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:60',
            'date' => 'required|date|after:yesterday',
            'time' => 'nullable',
            'participants' => 'required|string',
            'description' => 'required|string',
            'place' => 'required|string|max:100',
            'cost' => 'required|numeric|min:0|max:99999',
            'capacity_per_resident' => 'nullable|numeric|min:0|max:99999',
            'capacity_event' => 'nullable|numeric|min:0|max:99999',
            'rules' => 'nullable|array',
        ]);

        // Convierte el campo 'time' a un objeto Carbon y resta 6 horas porque lo guarda en otra zona la cual suma 6 horas
        $time = Carbon::parse($request->time)->subHours(6);

        $extra_data = [
            "frax_id" => auth()->user()->frax_id,
            "time" => $time,
           ];

        $community_event = CommunityEvent::create($request->except('imageCover', 'time') + $extra_data);

        // Guardar el archivo en la colección 'imageCover'
        if ($request->hasFile('imageCover')) {
            $community_event->addMediaFromRequest('imageCover')->toMediaCollection('imageCover');
        }

        return to_route('community-events.index');
    }

    
    public function show(CommunityEvent $community_event)
    {
       //
    }

    
    public function edit($community_event_id)
    {
        $community_event = CommunityEvent::with('media')->find($community_event_id);

        // return $community_event;
        return inertia('CommunityEvent/Edit', compact('community_event'));
    }

    
    public function update(Request $request, CommunityEvent $community_event)
    {
        $request->validate([
            'name' => 'required|string|max:60',
            'date' => 'required|date|after:yesterday',
            'time' => 'nullable',
            'participants' => 'required|string',
            'description' => 'required|string',
            'place' => 'required|string|max:100',
            'cost' => 'required|numeric|min:0|max:99999',
            'capacity_per_resident' => 'nullable|numeric|min:0|max:99999',
            'capacity_event' => 'nullable|numeric|min:0|max:99999',
            'rules' => 'nullable|array',
        ]);

         // Convierte el campo 'time' a un objeto Carbon y resta 6 horas
         $time = Carbon::parse($request->time)->subHours(6);

        $community_event->update($request->except('imageCover', 'time') + ['time' => $time]);

        // media ---------------------------------------------------
        // Eliminar imágenes antiguas solo si se borró desde el input y no se agregó una nueva
        if ($request->coverImageCleared) {
            $community_event->clearMediaCollection('imageCover');
        }

        return to_route('community-events.index');
    }


    public function updateWithMedia(Request $request, CommunityEvent $community_event)
    {
        $request->validate([
            'name' => 'required|string|max:60',
            'date' => 'required|date|after:yesterday',
            'time' => 'nullable',
            'participants' => 'required|string',
            'description' => 'required|string',
            'place' => 'required|string|max:100',
            'cost' => 'required|numeric|min:0|max:99999',
            'capacity_per_resident' => 'nullable|numeric|min:0|max:99999',
            'capacity_event' => 'nullable|numeric|min:0|max:99999',
            'rules' => 'nullable|array',
        ]);

         // Convierte el campo 'time' a un objeto Carbon y resta 6 horas
        $time = Carbon::parse($request->time)->subHours(6);

        $community_event->update($request->except('imageCover', 'time') + ['time' => $time]);

        // media ---------------------------------------------------
        // Eliminar imágenes antiguas solo si se borró desde el input y no se agregó una nueva
        if ($request->coverImageCleared) {
            $community_event->clearMediaCollection('imageCover');
        }

        // Eliminar imagen antigua solo si se proporciona nueva imagen
        if ($request->hasFile('imageCover')) {
            $community_event->clearMediaCollection('imageCover');
        }

        // Guardar el archivo en la colección 'imageCover'
        if ($request->hasFile('imageCover')) {
            $community_event->addMediaFromRequest('imageCover')->toMediaCollection('imageCover');
        }
                
        return to_route('community-events.index');
    }

    
    public function destroy(CommunityEvent $community_event)
    {
        $community_event->delete();
    }


    public function fetchCurrentCapacity()
{
    $community_event_id = request('community_event_id');

    // Utilizamos la función sum para calcular la suma directamente en la consulta
    $current_capacity = CommunityEventUser::where('community_event_id', $community_event_id)
        ->sum('participants_quantity');

    return response()->json(['current_capacity' => $current_capacity]);
}
}
