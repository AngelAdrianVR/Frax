<?php

namespace App\Http\Controllers;

use App\Models\CommonArea;
use Illuminate\Http\Request;

class CommonAreaController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        return inertia('CommonArea/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'preparation_hours' => 'required|numeric|min:0',
            'days_anticipation_booking' => 'required|numeric|min:0',
            'cost' => 'required|numeric|min:0',
            'capacity' => 'required|numeric|min:0',
            'is_multiple_reserved' => 'boolean',
            'description' => 'required|string|max:800',
            'notes' => 'required|string|max:800',
            'features' => 'required|array|min:1',
            'schedule' => 'required|array|min:1',
        ]);

        $common_area = CommonArea::create($validated + ['frax_id' => auth()->user()->frax_id]);

         // Subir y asociar la imagen
         $common_area->addAllMediaFromRequest('images')->each(fn ($file) => $file->toMediaCollection());

        return to_route('common-areas-users.index');
    }

    public function show(CommonArea $commonArea)
    {
        //
    }

    public function edit(CommonArea $commonArea)
    {
        //
    }

    public function update(Request $request, CommonArea $commonArea)
    {
        //
    }

    public function destroy(CommonArea $commonArea)
    {
        //
    }
}
