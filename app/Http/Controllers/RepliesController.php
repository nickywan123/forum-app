<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function edit(Reply $reply){

        return view('threads.replies.edit', compact('reply'))->render();

    }

    public function update(Request $request,Reply $reply){

        $this->validate($request, [
            'body' => 'required'
        ],[
            'body.required' => 'Please fill in your reply'
        ]);

        $reply->update([
            'body'=> $request->body
        ]);

        return view('threads.replies.reply-body', compact('reply'))->render();
    }
    
    public function store(Request $request, $channel_id,Thread $thread){

        //limit only one reply per minute
       if(Gate::denies('create',new Reply)){
         Session::flash('error', 'You are replying too frequent. Please try again later.');
         return back()->withInput();
       }

        $this->validate($request, [
            'body' => 'required'
        ],[
            'body.required' => 'Please fill in your reply'
        ]);

        $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);
        Session::flash('message', 'Your reply has been posted.');
        
        return back();
    }

    public function destroy(Reply $reply){

        $this->authorize('update',$reply);

        $reply->delete();

        return back();
    }
}
