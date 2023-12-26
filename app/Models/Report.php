<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'is_solved',
        'user_id',
        'post_id',
        'comment_id',
    ];

    //relationships
    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function post() :BelongsTo
    {
        return $this->belongsTo(Post::class);
    }


    public function comment() :BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }
}
