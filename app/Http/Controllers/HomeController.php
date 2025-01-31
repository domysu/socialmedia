<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Post;
class HomeController extends Controller
{
    
    public function index(Request $request)
    {

       $posts = Post::query()->withCount('reactions')->latest()->paginate(20);

        return Inertia::render('Home', [
            
            'posts'=> PostResource::collection($posts),
        ]);
    }
}
