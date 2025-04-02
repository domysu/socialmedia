<?php

namespace App\Http\Controllers;

use App\Http\Enums\ReactionEnum;
use App\Http\Requests\CommentRequest;
use App\Models\Post;
use App\Models\PostAttachment;
use Illuminate\Http\Request;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Requests\StorePostRequest;
use App\Mode;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Http\Resources\CommentResource;
use App\Models\Reactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {

        $user = $request->user();
        $data = $request->validated();
        $post = Post::create($data);
        try {
            /** @var \Illuminate\Http\UploadedFile[] $files */
            $files = $data['attachments'] ?? [];
            foreach ($files as $file) {

                $path = $file->store('attachments/' . $post->id, 'public');
                $allFilePaths[] = $path;
                PostAttachment::create([
                    'post_id' => $post->id,
                    'name' =>  $file->getClientOriginalName(),
                    'path' => $path,
                    'mime' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'created_by' => $user->id
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            foreach ($allFilePaths as $path) {
                Storage::disk('public')->delete($path);
            }
            DB::rollBack();
            throw $e;
        }
        return redirect()->back()->with('success', 'Post created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {

        $user = $request->user();
        try {
            $post->update($request->validated());
            $data = $request->validated();

            /** @var \Illuminate\Http\UploadedFile[] $files */
            $files = $data['attachments'] ?? [];
            foreach ($files as $file) {
                $path = $file->store('attachments/' . $post->id, 'public');
                $allFilePaths[] = $path;
                PostAttachment::create([
                    'post_id' => $post->id,
                    'name' =>  $file->getClientOriginalName(),
                    'path' => $path,
                    'mime' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'created_by' => $user->id




                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            print_r($e);
            DB::rollBack();
            throw $e;
        }

        // Delete attachments
        if ($request->has('deletedAttachments')) { // Check if deletedAttachments exists in the request
            foreach ($request->deletedAttachments as $attachmentId) {
                print($attachmentId);
                $attachment = PostAttachment::find($attachmentId);

                if ($attachment) {
                    $attachment->delete();
                    Storage::disk('public')->delete($attachment->path);
                }
            }
        }

        return back();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $user = auth()->user();
        if ($user->id == $post->user_id) {
            $post->delete();
            return back();
        }
    }

    public function PostReaction(Post $post, Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'reaction' => [Rule::enum(ReactionEnum::class)],

        ]);

        $existingReaction = $post->reactions()->where('user_id', $user->id)->first();
        if($existingReaction)
        {
            $existingReaction->delete();
        }
        else{
        $reaction = Reactions::create([
            'object_id' => $post->id,
            'object_type' => Post::class,
            'user_id' => $user->id,
            'type' => $data['reaction']

        ]);

        $reactions = $reaction::where('object_id', $post->id)->count();

        return response([
            'success' => true,
            'reactions' => $reactions,

        ]);
    }
    }

    public function postComment(Post $post, Request $request)
    {
        $user = Auth::id();
        $data = $request->validate([
            'comment' => 'required|string',
            'parent_id' => ['nullable'],    
        ]);
        $postComment = Comment::create([
            'post_id' => $post->id,
            'comment' => $data['comment'],
            'user_id' => $user,
            'parent_id' => $data['parent_id'],
        

        ]);


        return response(new CommentResource($postComment), 201);
    }
    public function updateComment(Comment $comment, CommentRequest $request)
    {
        $user = Auth::id();
        $data = $request->validated();
        $comment->update([
            'comment' => $data['comment'],
        
            
        ]);

        return response(new CommentResource($comment), 200);
    }

    public function deleteComment(Comment $comment, Request $request)
    {
        $user = Auth::id();
       
        if($user == $comment->user_id)
        {
            
            $comment->delete();
            return response('', 204);
        }
        else return response()->json(['error' => 'Forbidden'], 403);

        
    }
    public function commentReaction(Request $request, Comment $comment)
    {
        $user = Auth::user();
        $data = $request->validate([
            'reaction' => [Rule::enum(ReactionEnum::class)],
           

        ]);
        $existingReaction = $comment->reactions()->where('user_id', $user->id)->first();

        if($existingReaction)
        {
            $existingReaction->delete();
        }
        else{
        $reaction = Reactions::create([
            'object_id' => $comment->id,
            'object_type' => Comment::class,
            'user_id' => $user->id,
            'type' => $data['reaction'],
            

        ]);

        $reactions = $reaction::where('object_id', $comment->id)->count();

        return response([
            'success' => true,
            'reactions' => $reactions,

        ]);
    }
    }
 

}
