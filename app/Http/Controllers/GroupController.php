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
use App\Http\Enums\GroupUserStatus;
use App\Http\Enums\GroupUserRole;
use App\Http\Requests\InviteUserRequest;
use App\Notifications\GroupInviteNotification;
use Illuminate\Support\Carbon;



class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Group $group)
    {

        $isInGroup = $group->groupUsers()
        ->where('user_id', auth()->id())
        ->where('status', GroupUserStatus::APPROVED)
        ->exists();

       return Inertia::render('Group', [
        'group' => new GroupResource($group),
        'status' => session('status'),
        'isInGroup' => $isInGroup



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
            'status' => GroupUserStatus::APPROVED,
            
            'user_id' => Auth::id(),
            'group_id' => $group->id,
            'role' => GroupUserRole::ADMIN,
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

    public function inviteUser(Group $group, InviteUserRequest $request)
    {
            
            $data = $request->validated();
            $identifier = $request->input('identifier');
            $user = filter_var($identifier, FILTER_VALIDATE_EMAIL)
            ? User::where('email', $identifier)->first()
            : User::where('username', $identifier)->first();

            if($user == null)
            {
             return back()->withErrors(['identifier' => 'User not found.']);
            }

            $userInGroup = $group->GroupUsers->firstWhere('user_id', $user->id);
            if($userInGroup != null && $userInGroup->status == 'pending')
            {
                $userInGroup->delete();

            }
            else if($userInGroup != null && $userInGroup->status != 'pending'){
                return back()->withErrors(['identifier' => 'User is already in group']);
            }

            $groupUser = GroupUser::create([
            'status' => GroupUserStatus::PENDING,
            'user_id' => $user->id,
            'token' => bin2hex(random_bytes(16)),
            'token_expire_date' => Carbon::now()->addHours(24),
            'group_id' => $group->id,
            'role' => GroupUserRole::USER,
            'created_by' => Auth::id(),

        ]);
        $user->notify(new GroupInviteNotification($group, $groupUser));
        return back()->with('message', 'User invited');

    }

    public function accept($token)
    {
        $groupUser = GroupUser::Where('token', $token)->where('token_expire_date', '>', Carbon::now())->where('token_used', null)->first();
        if(! $groupUser)
        {
            return Inertia::Render('Error',[
                'body' => 'Token is invalid or expired! ',
            ]);
        }
        $groupUser->update([
            'status' => GroupUserStatus::APPROVED,
            'token_used' => Carbon::now(),
        ]);
        return Inertia::render('Success', [
            'body' => "Succesfully joined the group",
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
                ->where('group_id', $group->id)
                ->where('status', GroupUserStatus::APPROVED);
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
