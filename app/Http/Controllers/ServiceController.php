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
        //
    }

    
    public function store(Request $request)
    {
        //
    }

    
    public function show(Service $service)
    {
        //
    }

    
    public function edit(Service $service)
    {
        //
    }

    
    public function update(Request $request, Service $service)
    {
        //
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
