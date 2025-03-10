<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'slug' => $this->slug,
            'cover_path' => $this->cover_path,
            'thumbnail_path' => $this->thumbnail_path,
            'about' => $this->about,
            'user_id' => $this->user_id,
            'deleted_at' => $this->deleted_at,
            'deleted_by' => $this->deleted_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'users' => GroupUserResource::collection($this->GroupUsers),
        ];
    }
}
