<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\PostResource;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Follower;
use App\Models\Post;
use App\Http\Resources\FollowerResource;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

     public function index(User $user)
     {
        
        
        $followers = Follower::query()
        ->where('user_id', $user->id)
        ->with('follower')
        ->latest()
        ->paginate(10);

         $followings = Follower::query()
        ->where('follower_id', $user->id)
        ->with('user')
        ->latest()
        ->paginate(10);

        $userPosts = Post::query()->where('user_id', $user->id)->withCount('reactions')
        ->latest()
        ->paginate(3);

        $userPosts = PostResource::collection($userPosts);
        if(request()->wantsJson())
        {
         
            return $userPosts;
            
        }

        return Inertia::render('Profile/View', [
            'mustVerifyEmail' => $user instanceof MustVerifyEmail,
            'status' => session('status'),
            'user' => new UserResource($user),
            'posts' => $userPosts,
            'followers' => FollowerResource::collection($followers),
            'followings' => FollowerResource::collection($followings),
            
        ]);
            
     }
     public function edit_index(User $user)
     {
        return Inertia::render('Profile/Edit', [
        'mustVerifyEmail' => $user instanceof MustVerifyEmail,
        'status'=> session('status'),
        ]);
     }
 

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
       
        $request->user()->save();

        return Redirect::route('profile.updateIndex');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function updateImage(Request $request)
    {
        $user = $request->user();
       
    
            $data = $request->validate([
                'cover' => ['nullable', 'image'],
                'avatar' => ['nullable', 'image']
            ]);
    
            $avatar = $data['avatar'] ?? null;
            $cover = $data['cover'] ?? null;
    
            if ($cover) {
                $path = $cover->store('covers/'.$user->id, 'public');
                $user->cover_path = $path;
                $user->save();
         
            }
           if($avatar){
                $path = $avatar->store('avatars/'.$user->id, 'public');
                $user->avatar_path = $path;
                $user->save();
            }
            
    
            return redirect()->route('profile', [$user])->with('status', 'Profile updated');
    }
  public function followUser(Request $request, Follower $follower)
    {
        $data = $request->validate([
            'user_id' => ['required'],
        ]);
        $user = $request->user();

        $alreadyFollowing = Follower::where('follower_id', Auth::id())->where('user_id', $data['user_id'])->first();
        if($alreadyFollowing)
        {
          $alreadyFollowing->delete();
        } 
        else{
            $Follower = Follower::create([
                'user_id' => $data['user_id'],
                'follower_id' => Auth::id(),
            ]);
        }
        
        return response([
            
            'follower' => new UserResource(Auth::user()),
        
        ]);
    }
  
}
