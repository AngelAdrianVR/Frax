<?php

namespace App\Http\Controllers;

use App\Models\Support;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    
    public function index()
    {
        return inertia('Support/Index');
    }

    
    public function create()
    {
        return inertia('Support/Create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:40',
            'description' => 'required|string',
        ]);

        $support = Support::create($request->except('image') + ['user_id' => auth()->id(), 'frax_id' => auth()->user()->frax_id]);

        // archivos adjuntos
        $support->addAllMediaFromRequest()->each(fn ($file) => $file->toMediaCollection());

    }

    
    public function show(Support $support)
    {
        //
    }

    
    public function edit(Support $support)
    {
        //
    }

    
    public function update(Request $request, Support $support)
    {
        //
    }

    
    public function destroy(Support $support)
    {
        //
    }
}
