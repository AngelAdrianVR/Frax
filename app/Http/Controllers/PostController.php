<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    
    public function index()
    {
        $posts = PostResource::collection(Post::with('user', 'media', 'comments.user')->latest()->where('frax_id', auth()->user()->frax_id)->get());

        // return $posts;

        return inertia('Community/Index', compact('posts'));
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
        $post->update($request->except('media'));
    }


    public function updateWithMedia(Request $request, $postId)
    {
        $post = Post::find($postId);

        $post->update($request->except('media'));

        //clear media
        $post->clearMediaCollection();

        // Subir imagen
        $post->addAllMediaFromRequest()->each(fn ($file) => $file->toMediaCollection());
    }

    
    public function destroy(Post $post)
    {
        $post->delete();
    }


    public function incrementViews($postId)
    {
        $post = Post::findOrFail($postId);
        $post->increment('views'); // Incrementa la variable 'views' en 1
        return response()->json(['success' => true]);
    }


    public function storeComment($postId, Request $request)
    {
        $post = Post::find($postId);
        $comment = new Comment([
            'content' => $request->comment,
            'user_id' => auth()->id(),
        ]);
        $post->comments()->save($comment);

        return response()->json(['item' => $comment->fresh()->load('user')]);
    }
}
