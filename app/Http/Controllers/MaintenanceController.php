<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Maintenance;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenances = Maintenance::select('id', 'name', 'status')
            ->with('media')
            ->withCount('comments')
            ->where('status', '!=', 3)
            ->get();

        return inertia('Maintenance/Index', compact('maintenances'));
    }

    public function create()
    {
        return inertia('Maintenance/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:400',
            'location' => 'required|string|max:255',
            'is_anonymous_report' => 'boolean'
        ]);

        $maintenance = Maintenance::create($validated + ['user_id' => auth()->id()]);
        // Subir y asociar la imagen
        $maintenance->addAllMediaFromRequest()->each(fn ($file) => $file->toMediaCollection());

        return to_route('maintenances.index');
    }

    public function show(Maintenance $maintenance)
    {
        $maintenance = $maintenance->load(['media', 'user', 'evidence', 'comments.user']);
        return inertia('Maintenance/Show', compact('maintenance'));
    }

    public function edit(Maintenance $maintenance)
    {
        return inertia('Maintenance/Edit', compact('maintenance'));
    }

    public function update(Request $request, Maintenance $maintenance)
    {
        // return $request->all();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:400',
            'location' => 'required|string|max:255',
            'is_anonymous_report' => 'boolean'
        ]);

        $maintenance->update($validated);

        return to_route('maintenances.show', $maintenance);
    }

    public function updateWithMedia(Request $request, Maintenance $maintenance)
    {
        // return $request->all();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:400',
            'location' => 'required|string|max:255',
            'is_anonymous_report' => 'boolean'
        ]);

        $maintenance->update($validated);

        // Subir y asociar la imagen
        $maintenance->clearMediaCollection();
        $maintenance->addAllMediaFromRequest()->each(fn ($file) => $file->toMediaCollection());

        return to_route('maintenances.show', $maintenance);
    }

    public function destroy(Maintenance $maintenance)
    {
        //
    }

    public function storeComment(Maintenance $maintenance, Request $request)
    {
        $comment = new Comment([
            'content' => $request->comment,
            'user_id' => auth()->id(),
        ]);
        $maintenance->comments()->save($comment);

        return response()->json(['item' => $comment->fresh()->load('user')]);
    }
}
