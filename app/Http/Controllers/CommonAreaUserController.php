<?php

namespace App\Http\Controllers;

use App\Models\CommonArea;
use App\Models\CommonAreaUser;
use Illuminate\Http\Request;

class CommonAreaUserController extends Controller
{
    /**
     * Display a listing of available common areas to booking.
     */
    public function index()
    {
        $common_areas = CommonArea::latest()->get();
        
        return inertia('CommonAreaUser/Index', compact('common_areas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $common_area = CommonArea::find($request->common_area_id);

        return inertia('CommonAreaUser/Create', compact('common_area'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CommonAreaUser $commonAreaUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CommonAreaUser $commonAreaUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CommonAreaUser $commonAreaUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommonAreaUser $commonAreaUser)
    {
        //
    }
}
