<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{

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
  
}
