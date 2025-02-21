<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'body' => $this->comment,
            'user' => [

                "id" => $this->user->id,
                "name" => $this->user->name,
                "username" =>  $this->user->username,
                "cover_url" =>  Storage::url($this->user->cover_path),    
                "avatar_url" =>  Storage::url($this->user->avatar_path),
            ],
            'comments' => CommentResource::collection($this->comments),
            'has_reacted' => $this->reactions->contains('user_id', auth()->id()), // TODO: do a query instead in HomeController
            'parent_id' => $this->parent_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'reactions' => $this->reactions_count,
          


        ];
    }
}
