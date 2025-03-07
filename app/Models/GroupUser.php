<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model
{
    const UPDATED_AT = NULL;
    const CREATED_BY = NULL;
    protected $fillable = ['role', 'status', 'user_id', 'group_id','created_by'];

}
