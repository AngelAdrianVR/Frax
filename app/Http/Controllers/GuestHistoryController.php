<?php

namespace App\Http\Controllers;

use App\Http\Resources\GuestHistoryResource;
use App\Models\GuestHistory;
use Illuminate\Http\Request;

class GuestHistoryController extends Controller
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
        //
    }

    
    public function show(GuestHistory $guestHistory)
    {
        //
    }

    
    public function edit(GuestHistory $guestHistory)
    {
        //
    }

    
    public function update(Request $request, GuestHistory $guestHistory)
    {
        //
    }

    
    public function destroy(GuestHistory $guestHistory)
    {
        //
    }


    public function getAll()
    {
        $guest_histories = GuestHistoryResource::collection(GuestHistory::latest()->where('user_id', auth()->id())->get());

        return response()->json(['items' => $guest_histories]);
    }
}
