<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Resources\UserResource;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

     public function index(User $user)
     {
        return Inertia::render('Profile/View', [
            'mustVerifyEmail' => $user instanceof MustVerifyEmail,
            'status' => session('status'),
            'user' => new UserResource($user),
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

        return Redirect::route('profile');
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
            
    
            return redirect()->route('profile', [$user])->with('status', 'Profile updated!');
    }
}
