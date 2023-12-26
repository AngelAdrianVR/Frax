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
        //Optimizacion para rapidez. No carga todos los datos, sólo los siguientes para hacer la busqueda y mostrar la tabla en index
        $pre_posts = PostResource::collection(Post::with('user', 'media', 'comments.user')->latest()->where('frax_id', auth()->user()->frax_id)->get());    
        
        $posts = $pre_posts->map(function ($post) {

            $media = $post->media->map(function ($media_file) {
                return [
                    'id' =>$media_file->id,
                    'original_url' =>$media_file->original_url,
                ];
            });

            $comments = $post->comments->map(function ($comment) {
                return [
                    'id' =>$comment->id,
                    'content' =>$comment->content,
                    'user' => [
                        'id' => $comment->user->id,
                        'name' => $comment->user->name,
                        'profile_photo_path' => $comment->user->profile_photo_path,
                        'profile_photo_url' => $comment->user->profile_photo_url,
                    ],
                    'created_at' =>$comment->created_at?->diffForHumans(),
                ];
            });

            return [
                'id' => $post->id,
                'title' => $post->title,
                'body' => $post->body,
                'views' => $post->views,
                'likes' => $post->likes,
                'media' => $media,
                'comments' => $comments,
                'user' => [
                    'id' => $post->user->id,
                    'name' => $post->user->name,
                    'profile_photo_path' => $post->user->profile_photo_path,
                    'profile_photo_url' => $post->user->profile_photo_url,
                ],
                'created_at' => $post->created_at->isoFormat('DD MMM, YYYY h:mm A'),
            ];
        });

        // return $posts;

        return inertia('Community/Index', compact('posts'));
    }


    public function loadPosts($start, $limit) 
    {
        $posts = Post::skip($start)->take($limit)->get();
        return response()->json($posts);
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
    }


    public function incrementLikes($postId)
    {
        $post = Post::findOrFail($postId);
        $post->increment('likes'); // Incrementa la variable 'likes' en 1
        return response()->json(['item' => $post->fresh()]);
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
