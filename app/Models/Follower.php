<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use function Symfony\Component\Clock\now;

class Follower extends Model
{
    
    const UPDATED_AT = NULL;
    protected $fillable = ['user_id', 'follower_id'];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function follower(): BelongsTo
    {
        return $this->belongsTo(User::class, 'follower_id');
    }

}
