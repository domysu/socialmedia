<?php

namespace App\Http\Controllers;

use App\Http\Resources\FollowerResource;
use App\Http\Resources\GroupResource;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Models\Group;
use App\Models\Follower;

class HomeController extends Controller
{
    
    public function index(Request $request)
    {

        $userId = Auth::id();

       $posts = Post::query()
       ->withCount('reactions')
       ->with([
        'comments' => function($query){
            $query->withCount('reactions');
        },
        'reactions' => function($query) use ($userId){
            $query->where('user_id', $userId);

        },
      

       ])
       ->latest()
       ->paginate(3);
       
       
        $posts = PostResource::collection($posts);
        if($request->wantsJson()){
            return $posts;
        }

        $groups = Group::query()
        ->with('GroupUsers')
        ->latest()
        ->paginate(15);  

        $followers = Follower::query()
        ->with(['user', 'follower'])
        ->latest()
        ->get();
        
        return Inertia::render('Home', [
            
            'posts' => $posts,
            'groups' => GroupResource::collection($groups),
            'followers' => FollowerResource::collection($followers),
        ]);
    }
}
