<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommunityEventResource;
use App\Models\CommunityEvent;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CommunityEventController extends Controller
{
    
    public function index()
    {
        $community_events = CommunityEventResource::collection(CommunityEvent::latest()->with('media')->where('frax_id', auth()->user()->frax_id)->get());

        // return $community_events;

        return inertia('CommunityEvent/Index', compact('community_events'));
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
        ]);

        // Convierte el campo 'time' a un objeto Carbon y resta 6 horas
        $time = Carbon::parse($request->time)->subHours(6);

        $extra_data = [
            "frax_id" => auth()->user()->frax_id,
            "time" => $time,
           ];

        $community_event = CommunityEvent::create($request->except('imageCover', 'time') + $extra_data);

        // Subir y asociar la imagen del evento a la colección 'imageCover'
       if ($request->hasFile('imageCover')) {
        $communityEventImagePath = $request->file('imageCover')->store('imageCover', 'public');
        $community_event->addMedia(storage_path('app/public/' . $communityEventImagePath))
        ->toMediaCollection('imageCover');
        }

        return to_route('community-events.index');
    }

    
    public function show($community_event_id)
    {
        $community_event = CommunityEventResource::make(CommunityEvent::with('media')->find($community_event_id));

        // return $community_event;

        return inertia('CommunityEvent/Show', compact('community_event'));
    }

    
    public function edit(CommunityEvent $community_event)
    {
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
        ]);

         // Convierte el campo 'time' a un objeto Carbon y resta 6 horas
         $time = Carbon::parse($request->time)->subHours(6);

        $community_event->update($request->except('imageCover', 'time') + ['time' => $time]);

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
        ]);

         // Convierte el campo 'time' a un objeto Carbon y resta 6 horas
        $time = Carbon::parse($request->time)->subHours(6);

        $community_event->update($request->except('imageCover', 'time') + ['time' => $time]);

        // media
         $community_event->clearMediaCollection('imageCover');

         // Subir y asociar la imagen del evento a la colección 'imageCover'
       if ($request->hasFile('imageCover')) {
        $communityEventImagePath = $request->file('imageCover')->store('imageCover', 'public');
        $community_event->addMedia(storage_path('app/public/' . $communityEventImagePath))
        ->toMediaCollection('imageCover');
        }
                
        return to_route('community-events.index');
    }

    
    public function destroy(CommunityEvent $community_event)
    {
        $community_event->delete();

    }
}
