<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Group extends Model
{
    
    use SoftDeletes;
    use HasSlug;
    const UPDATED_AT = NULL;
    protected $fillable =[ 'name', 'description', 'slug', 'auto_approval', 'cover_path', 'thumbnail_path', 'about', 'user_id', 'deleted_at', 'deleted_by', 'created_at', 'updated_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function groupUsers(): HasMany
    {
        return $this->hasMany(GroupUser::class);
    }


    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['name'])
            ->saveSlugsTo('slug')
            ->usingSeparator('-')
            ->doNotGenerateSlugsOnUpdate();
    }

}
