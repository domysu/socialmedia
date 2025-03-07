<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Models\Group;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\GroupUser;


class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return Inertia::render('Group');
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
            'status' => 'On',
            'user_id' => Auth::id(),
            'group_id' => $group->id,
            'role' => 'User',
            'created_by' => Auth::id(),

        ]);
        
        return back();
         
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        //
    }
}
