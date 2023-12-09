<?php

namespace App\Http\Controllers;

use App\Http\Resources\NormResource;
use App\Models\Norm;
use Illuminate\Http\Request;

class NormController extends Controller
{
    
    public function index()
    {
        $frax_id = auth()->user()->frax_id;

        $norms = NormResource::collection(Norm::where('frax_id', $frax_id)->get());

        return inertia('Norm/Index', compact('norms'));
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
    }

    
    public function show(Norm $norm)
    {
        //
    }

    
    public function edit(Norm $norm)
    {
        //
    }

    
    public function update(Request $request, Norm $norm)
    {
        //
    }

    
    public function destroy(Norm $norm)
    {
        //
    }
}
