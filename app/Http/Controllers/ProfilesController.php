<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Http\Requests\UpdateProfileRequest;
use App\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function show(User $user){
     
      return view('profiles.show',compact('user'));
    }

    public function update(UpdateProfileRequest $request, User $user){

        $this->authorize('update',$user);

        $validated = $request->validated();

        $user->update([
            'name' => $request->input('name')
        ]);


        return redirect($user->path())
                ->with('message',"Profile has been updated")
                ->with('edit',$request->input('edit'));
        
    }

    public function activity(User $user){
      
        return view('profiles.activities.show',[
            'profileUser' => $user,
            'activities' => Activity::feed($user)
        ]);
    }

   

}
