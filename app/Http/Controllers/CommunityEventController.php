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
            "qr_code" => $request->qr_code //generado en el mounted de la vista.
           ];

        $community_event = CommunityEvent::create($request->except('imageCover', 'time') + $extra_data);

        // Subir y asociar la imagen de la normativa a la colección 'imageCover'
       if ($request->hasFile('imageCover')) {
        $communityEventImagePath = $request->file('imageCover')->store('imageCover', 'public');
        $community_event->addMedia(storage_path('app/public/' . $communityEventImagePath))
        ->toMediaCollection('imageCover');
        }
        return to_route('community-events.index');
    }

    
    public function show(CommunityEvent $communityEvent)
    {
        //
    }

    
    public function edit(CommunityEvent $communityEvent)
    {
        //
    }

    
    public function update(Request $request, CommunityEvent $communityEvent)
    {
        //
    }

    
    public function destroy(CommunityEvent $communityEvent)
    {
        //
    }
}
