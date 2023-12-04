<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    
    public function index()
    {
        //
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:30',
            'guests_quantity' => 'required|numeric|min:0|max:100',
            'event_date' => 'date|after:yesterday',
            'start_time' => 'nullable|string',
            'end_time' => 'nullable|string',
            'location' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:190',
            'qr_code' => 'nullable|string',
        ]);

        Event::create($request->all() + ['user_id' => auth()->id()]);

        return to_route('guests.index');
    }

    
    public function show(Event $event)
    {
        //
    }

    
    public function edit(Event $event)
    {
        //
    }

    
    public function update(Request $request, Event $event)
    {
        //
    }

    
    public function destroy(Event $event)
    {
        //
    }
}
