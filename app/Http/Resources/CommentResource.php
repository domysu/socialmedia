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
            'comment' => $this->comment,
            'user' => [

                "id" => $this->user->id,
                "name" => $this->user->name,
                "username" =>  $this->user->username,
                "cover_url" =>  Storage::url($this->user->cover_path),    
                "avatar_url" =>  Storage::url($this->user->avatar_path),
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,


        ];
    }
}
