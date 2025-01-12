<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostAttachment;
use Illuminate\Http\Request;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Requests\StorePostRequest;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        return back();
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
}
