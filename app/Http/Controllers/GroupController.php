<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Http\Resources\GroupResource;
use App\Http\Resources\GroupUserResource;
use App\Models\Group;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\GroupUser;
use App\Models\User;



class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Group $group)
    {
       return Inertia::render('Group', [
        'group' => new GroupResource($group),
        'status' => session('status')


       ]);
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
    public function store(StoreGroupRequest $request)
    {
        $data = $request->validated();
        $group = Group::create([
            'user_id' => Auth::id(), 
            'name' => $data['name'],
            'about' => $data['about'],
            'auto_approval' => $data['auto_approval'],

        ]);
        $GroupUser = GroupUser::create([
            'status' => 'Approved',
            'user_id' => Auth::id(),
            'group_id' => $group->id,
            'role' => 'User',
            'created_by' => Auth::id(),

        ]);
        
        return response()->json(['status', 'Group created successfully']);
         
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
        $data = $request->validated();
        $group->update($data);
    

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        //
    }

    public function joinGroup(Group $group)
    {   
        
     
        $GroupUser = GroupUser::create([
            'status' => 'Approved',
            'user_id' => Auth::id(),
            'group_id' => $group->id,
            'role' => 'User',
            'created_by' => Auth::id(),

        ]);

        return response()->json([
            'message' => 'Successfully joined the group.',
            'GroupUser' => new GroupUserResource($GroupUser),
        ]);
    }   

    public function leaveGroup(Group $group)
    {
        $user = auth()->user();
        $foundUser = $group->GroupUsers->firstWhere('user_id', auth()->id());

      
        if ($foundUser) {
            $foundUser->delete(); 
            return response()->json([
                'message' => 'Successfully left the group',
                'GroupUser' => $foundUser,
                
                ]);
        }

            return response()->json(['message' => 'User not found']);
        
        
    }

    public function getUsers(Group $group, User $user)
    {
        
        $allUsers = $user->select('id', 'name', 'avatar_path', 'username')
        ->whereIn('id', function ($query) use ($group)
        {
            $query->select('user_id')
                ->from('group_users')
                ->where('group_id', $group->id);
        })->paginate(20);
        return $allUsers;

    }

    public function saveImage(Group $group, Request $request){    
        $data = $request->validate([
            'cover' => ['image', 'nullable'],
            'avatar' => ['image', 'nullable'],
        ]);
        $cover = $data['cover'] ?? null;
        $avatar = $data['avatar'] ?? null;

        if($cover)
        {
            $path = $cover->store('group/covers/'.$group->id, 'public');
            $group->cover_path = $path;
            $group->save();
        }
        if($avatar)
        {
            $path = $avatar->store('group/avatars/'.$group->id, 'public');
            $group->thumbnail_path = $path;
            $group->save();
        }
        return redirect()->route('group', $group->slug)->with('status', 'Group updated!');


    }
    public function AllGroups()
    {
        $groups = Group::query()
        ->with('GroupUsers')
        ->latest()
        ->paginate(15); 
        return Inertia::render('AllGroups', [
            'groups' => GroupResource::collection($groups),

        ]);

    }
}
