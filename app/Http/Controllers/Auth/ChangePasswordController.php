<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function changePassword(Request $request){
        
        $user = new User();
        $user = Auth::user();
        $this->authorize('update',$user);

        if (!(Hash::check($request->input('current-password'), Auth::user()->password))) {
            // The passwords matches the password of the user in the database
            return redirect()
                    ->back()
                    ->with("error","Your current password does not matches with the password you provided. Please try again.")
                    ->with('password', $request->input('password'));
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()
                    ->with("error","New Password cannot be same as your current password. Please choose a different password.")
                    ->with('password', $request->input('password'));
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:8|confirmed',
        ],
        [
            'new-password.min' => 'New password must be at least 8 characters',
            'new-password.confirmed' => 'The new password confirmation does not match'
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->input('new-password'));
        $user->save();

        return redirect()->back()->with("success","Password changed successfully !")
                                 ->with('password', $request->input('password'));

    }
}
