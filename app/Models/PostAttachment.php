<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostAttachment extends Model
{
   use HasFactory;
        CONST UPDATED_AT = null;
   protected $fillable = [
    'post_id',
    'mime',
    'size',
    'path',
    'name',
    'created_by',
    'created_at',
   ];
}
