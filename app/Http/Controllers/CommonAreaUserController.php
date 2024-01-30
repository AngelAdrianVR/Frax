<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommonAreaUserResource;
use App\Models\CommonArea;
use App\Models\CommonAreaUser;
use Illuminate\Http\Request;

class CommonAreaUserController extends Controller
{
    public function index()
    {
        $common_areas = CommonArea::where('frax_id', auth()->user()->frax_id)->latest()->get(['id']);

        return inertia('CommonAreaUser/Index', compact('common_areas'));
    }

    public function create(Request $request)
    {
        $common_area = CommonArea::with('media')->find($request->common_area_id);
        $reservations = CommonAreaUserResource::collection(CommonAreaUser::whereDate('date', '>=', today())
            ->whereHas('commonArea', function ($query) {
                $query->where('frax_id', auth()->user()->frax_id);
            })->get(['id', 'date', 'time']));

        return inertia('CommonAreaUser/Create', compact('common_area', 'reservations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'people_quantity' => 'required|numeric|min:1',
            'agree' => 'boolean',
            'common_area_id' => 'required|numeric|min:1',
        ]);

        $reservation = CommonAreaUser::create($validated + ['user_id' => auth()->id()]);
        
    }

    public function show(CommonAreaUser $commonAreaUser)
    {
        //
    }

    public function edit(CommonAreaUser $commonAreaUser)
    {
        //
    }

    public function update(Request $request, CommonAreaUser $commonAreaUser)
    {
        //
    }

    public function destroy(CommonAreaUser $commonAreaUser)
    {
        //
    }

    // public function activeReservations()
    // {
    //     $reservations = CommonAreaUser::whereDate('date', '<=', today())->get(['id', 'date', 'time']);

    //     return response()->json(['items' => $reservations]);
    // }
}
