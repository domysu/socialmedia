<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Storage;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            
            
                "id" => $this->id,
                "name" => $this->name,
                "email" => $this->email,
                "email_verified_at" => $this->avatar,
                "created_at" => $this->created_at,
                "updated_at" =>  $this->updated_at,
                "username" =>  $this->username,
                'about' => $this->about,
                "cover_url" =>  Storage::url($this->cover_path),
                "avatar_url" =>  Storage::url($this->avatar_path),
                
                    ];
    }
}
