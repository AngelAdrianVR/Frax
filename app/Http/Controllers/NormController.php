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

        $norms = NormResource::collection(Norm::with('media')->where('frax_id', $frax_id)->get());

        // return $norms;

        return inertia('Norm/Index', compact('norms'));
    }

    
    public function create()
    {
        return inertia('Norm/Create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:50',
            'description' => 'required|string',
        ]);

       $norm = Norm::create($request->except('imageCover') + ['frax_id' => auth()->user()->frax_id]);
       
       // Actualizar el campo 'updated_at' a null
       $norm->updated_at = null;
       $norm->save();
       
       // Subir y asociar la imagen de la normativa a la colección 'imageCover'
       if ($request->hasFile('imageCover')) {
           $normImagePath = $request->file('imageCover')->store('imageCover', 'public');
           $norm->addMedia(storage_path('app/public/' . $normImagePath))
           ->toMediaCollection('imageCover');
        }
        

       return to_route('norms.index');
    }


    public function storeNorm(Request $request)
    {
        $section = Norm::find($request->section_id);

        // Guardar el archivo en la colección 'norms'
        if ($request->hasFile('media')) {
            $section->addMediaFromRequest('media')->toMediaCollection('norms');
        }

       return to_route('norms.index');
    }

    
    public function show($norm_id)
    {
        $section = Norm::with('media')->find($norm_id);

        // return $section;
        return inertia('Norm/Show', compact('section'));
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
