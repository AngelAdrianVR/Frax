<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommunityEventResource;
use App\Models\CommunityEvent;
use App\Models\CommunityEventUser;
use Illuminate\Http\Request;

class CommunityEventUserController extends Controller
{
    
    public function index()
    {
        //
    }

    
    public function create()
    {
        $community_event_id = request('community_event_id');
        $community_event = CommunityEventResource::make(CommunityEvent::find($community_event_id));
        
        return inertia('CommunityEventUser/Create', compact('community_event'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:60',
            'address' => 'required|string',
            'phone' => 'required|string',
            'participants_quantity' => 'required|numeric|min:1|max:99',
        ]);

        CommunityEventUser::create($request->all());

        return to_route('community-events.index');
    }

    
    public function show(CommunityEventUser $community_event_user)
    {
        //
    }

    
    public function edit(CommunityEventUser $community_event_user)
    {
        //
    }

    
    public function update(Request $request, CommunityEventUser $community_event_user)
    {
        $community_event_user->update([
            'participants_quantity' => $request->participants_quantity
        ]);
    }

    
    public function destroy(CommunityEventUser $community_event_user)
    {
        $community_event_user->delete();

        return to_route('community-events.index');
    }

    public function getAll()
    {
        // guardo los eventos registrados
        $registered_events = request('registeredEvents');

        // Verifico si $registered_events es nulo y lo convierto a un array si es necesario
        if (!is_array($registered_events)) {
            $registered_events = [];
        }

        // Inicializo un array para almacenar todos los eventos
        $my_events = [];

        foreach ($registered_events as $event) {
            // Obtengo el evento y lo agrego al array
            $my_events[] = CommunityEventResource::make(CommunityEvent::with('media')->find($event['community_event_id']));
        }

        // return $registered_events;

        return response()->json(['items' => $my_events]);
    }
}
