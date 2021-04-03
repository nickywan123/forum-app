<?php

namespace App\Http\Controllers;

use App\Thread;
use App\ThreadSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ThreadSubscriptionsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function store($channelId,Thread $thread){


        $user_subscribed = $thread->IsSubscribedTo;

        //check if user is already subscribed
        if($user_subscribed){
            Session::flash('error', 'You are already subscribed to this thread');
            return view('partials.error-flash-messages')->render();
        }
        
        $thread->subscribe();

        Session::flash('success', 'You have subscribed to this thread');
        return view('partials.flash-messages')->render();
    }

    public function destroy($channelId,Thread $thread){

        $user_subscribed = $thread->IsSubscribedTo;

        if(!$user_subscribed){
            Session::flash('error', 'You are not subscribed to this thread');
            return view('partials.error-flash-messages')->render();
        }

        $thread->unsubscribe();

        Session::flash('success', 'You unsubscribed to this thread');
        return view('partials.flash-messages')->render();

    }

}
