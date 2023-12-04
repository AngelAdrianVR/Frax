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
        return inertia('FavoriteGuest/Create');
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

    public function getAll()
    {
        $favorite_guests = FavoriteGuestResource::collection(FavoriteGuest::all());

        return response()->json(['items' => $favorite_guests]);
    }
}
