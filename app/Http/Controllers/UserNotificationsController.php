<?php

namespace App\Http\Controllers;



use Illuminate\Notifications\Notifiable;
use Illuminate\Http\Request;

class UserNotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
        
    }

    public function index(){
        
        return auth()->user()->unreadNotifications;
    }

    public function destroy($user,$notification){
        auth()->user()->notifications()->findOrFail($notification)->markAsRead();
    }
}
