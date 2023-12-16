<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    
    public function index()
    {
        return inertia('Community/Index');
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        $post = Post::create($request->except('media') + ['user_id' => auth()->id(), 'frax_id' => auth()->user()->frax_id]);

        // Subir imagen
        $post->addAllMediaFromRequest()->each(fn ($file) => $file->toMediaCollection());

    }

    
    public function show(Post $post)
    {
        //
    }

    
    public function edit(Post $post)
    {
        //
    }

    
    public function update(Request $request, Post $post)
    {
        //
    }

    
    public function destroy(Post $post)
    {
        //
    }
}
