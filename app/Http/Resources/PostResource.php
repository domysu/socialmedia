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
use App\Http\Resources\CommentResource;
use App\Models\Comment;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $comments = $this->comments;
        
        return [
            'id' => $this->id,
            'body' => $this->body,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'user' => new UserResource($this->user),
            'group' => $this->group,
            'attachments' => PostAttachmentResource::collection($this->attachments),
            'reactions' => $this->reactions_count,
            'has_reacted' => $this->reactions->contains('user_id', auth()->id()), // TODO: do a query instead in HomeController
            'comment' => self::convertCommentsIntoTree($comments),
            'latest_comments' => CommentResource::collection($this->comments->sortByDesc('created_at')->take(5)),
            'num_of_comments' => count($comments),



        ];
    }
    private static function convertCommentsIntoTree($comments, $parentId = null): array
    {
        $branch = [];
        foreach ($comments as $comment) {
            if ($comment->parent_id == $parentId) {
                $children = self::convertCommentsIntoTree($comments, $comment->id);
                    $comment->childComments = $children;
                $branch[] = new CommentResource($comment);
            }
        }
        return $branch;
    }
}
