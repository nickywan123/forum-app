<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class SocialController extends Controller
{
    use AuthenticatesUsers;
    //redirecting the user to the OAuth provider
    public function redirect(){
        return Socialite::driver('facebook')->redirect();
    }

    //read the incoming request and retrieve the user's information
    // from the provider after they are authenticated
    public function callback(){

        try {
            $user = Socialite::driver('facebook')->user();
            
            //find facebook user login
            $find_user = User::where('facebook_id',$user->id)->first();

            if($find_user){
                Auth::login($find_user);
              
                return redirect('/home');
            }else{
                //check if new user email exist
                $user_email = User::where('email',$user->email)->first();

                if($user_email){
                    $update_user = User::where('email',$user_email->email)->update([
                        'facebook_id' => $user->id
                    ]);
                    Auth::login($user_email);
                }else{
                    //create a new user instance
                  $new_user = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'facebook_id' =>$user->id,
                    'password' => encrypt('dummy123')
                ]);
                    Auth::login($new_user);
                }
            
                return redirect('/home');
            }
        }catch(Exception $e) {

            dd($e->getMessage());
        }
        

    }
}
