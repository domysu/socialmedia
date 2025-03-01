<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{


    public array $childComments = [];
    protected $fillable = ['post_id', 'comment', 'user_id', 'body', 'parent_id'];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function post() : BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
    public function reactions(): MorphMany
    {
        return $this->morphMany(Reactions::class, 'object');
    }
    public function comments(): hasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }
    public function commentsCountRecursive()
{
    // Get all comments related to this comment, including their replies
    $comments = $this->comments()->withCount('comments')->get();

    // Sum the replies count recursively and add the count for the current comment
    return $comments->map(function($comment) {
        // Sum the number of replies, including nested ones
            
        return $comment;
    });
}
  
}
