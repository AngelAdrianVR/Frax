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
        //
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
