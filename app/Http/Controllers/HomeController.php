<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

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
       ->paginate(10);
       

      
        return Inertia::render('Home', [
            
            'posts'=> PostResource::collection($posts),
        ]);
    }
}
