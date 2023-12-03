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
        //
    }

    
    public function store(Request $request)
    {
        //
    }

    
    public function show(FavoriteGuest $favoriteGuest)
    {
        //
    }

    
    public function edit(FavoriteGuest $favoriteGuest)
    {
        //
    }

    
    public function update(Request $request, FavoriteGuest $favoriteGuest)
    {
        //
    }

    
    public function destroy(FavoriteGuest $favoriteGuest)
    {
        //
    }

    public function getFavoriteGuests()
    {
        $favorite_guests = FavoriteGuest::latest()->getOr([]);

        $favorite_guests = FavoriteGuestResource::collection($favorite_guests);

        return response()->json(['favorite_guests' => $favorite_guests]);
    }
}
