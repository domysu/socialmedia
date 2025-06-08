<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupUser extends Model
{
    const UPDATED_AT = NULL;
    const CREATED_BY = NULL;
    protected $fillable = ['role', 'status', 'user_id', 'group_id','created_by','token','token_expire_date', 'token_used'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

}
