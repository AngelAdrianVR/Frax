<?php

namespace App\Http\Controllers;

use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    
    public function index()
    {
        $internal_services = ServiceResource::collection(Service::with('media')->where('frax_id', auth()->user()->frax_id)->where('is_internal', true)->get());

        // return $internal_services;

        return inertia('Service/Index', compact('internal_services'));
    }

    
    public function create()
    {
        return inertia('Service/Create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:40',
            'phone' => 'required|string|max:13',
            'address' => 'nullable|string|max:70',
            'description' => 'required',
            'is_internal' => 'boolean',
        ]);

        $service = Service::create($request->except('imageCover') + ['frax_id' => auth()->user()->frax_id]);

        // Subir y asociar la imagen de portada del servicio a la colección 'imageCover'
       if ($request->hasFile('imageCover')) {
        $serviceImagePath = $request->file('imageCover')->store('imageCover', 'public');
        $service->addMedia(storage_path('app/public/' . $serviceImagePath))
        ->toMediaCollection('imageCover');
        }

        if ($request->is_internal) {
            return to_route('services.index', ['currentTab' => 1]);
        } else {
            return to_route('services.index', ['currentTab' => 2]);
        }
    }

    
    public function show(Service $service)
    {
        //
    }

    
    public function edit(Service $service)
    {
        return inertia('Service/Edit', compact('service'));
    }

    
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:40',
            'phone' => 'required|string|max:13',
            'address' => 'nullable|string|max:70',
            'description' => 'required',
            'is_internal' => 'boolean',
        ]);

        $service->update($request->except('imageCover'));

        if ($request->is_internal) {
            return to_route('services.index', ['currentTab' => 1]);
        } else {
            return to_route('services.index', ['currentTab' => 2]);
        }
    }


    public function updateWithMedia(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:40',
            'phone' => 'required|string|max:13',
            'address' => 'nullable|string|max:70',
            'description' => 'required',
            'is_internal' => 'boolean',
        ]);

        $service->update($request->except('imageCover'));

        // media
        $service->clearMediaCollection('imageCover');
        
            // Subir y asociar la imagen del evento a la colección 'imageCover'
        if ($request->hasFile('imageCover')) {
            $serviceImagePath = $request->file('imageCover')->store('imageCover', 'public');
            $service->addMedia(storage_path('app/public/' . $serviceImagePath))
            ->toMediaCollection('imageCover');
            }

        if ($request->is_internal) {
            return to_route('services.index', ['currentTab' => 1]);
        } else {
            return to_route('services.index', ['currentTab' => 2]);
        }

    }

    
    public function destroy(Service $service)
    {
        $service->delete();
    }


    public function getExternalServices()
    {
        $external_services = ServiceResource::collection(Service::with('media')->where('frax_id', auth()->user()->frax_id)->where('is_internal', false)->get());

        return response()->json(['items' => $external_services]);
    }

    public function getServicesHistory()
    {
        $services_history = ServiceResource::collection(Service::where('frax_id', auth()->user()->frax_id)->get());

        return response()->json(['items' => $services_history]);
    }
}
