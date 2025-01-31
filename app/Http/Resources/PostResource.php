<?php

namespace App\Http\Resources;


use Illuminate\Contracts\Cache\Store;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage as FacadesStorage;
use Storage;
use App\Http\Resources\PostAttachmentResource;
use App\Http\Resources\UserResource;
class PostResource extends JsonResource
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
            'body' => $this->body,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'user' => new UserResource($this->user),
            'group' => $this->group,
            'attachments' => PostAttachmentResource::collection($this->attachments),
            'reactions' => $this->reactions_count,
            'has_reacted' => $this->reactions->contains('user_id', auth()->id()),



        ];
    }
}
