<?php

namespace App\Http\Controllers;

use App\User;
use App\Thread;
use App\Channel;
use Jorenvh\Share\Share;
use Illuminate\Http\Request;
use App\Filters\ThreadFilters;
use App\ThreadSubscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ThreadsController extends Controller
{

    //Add middleware for authenticated user only
    public function __construct()
    {
        $this->middleware('auth')->except(['index','show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel, ThreadFilters $filters)
    {

        $threads = Thread::latest()->filter($filters);
        if($channel->exists){
            $threads->where('channel_id',$channel->id);
        }

        $threads = $threads->get();
        
        return view('threads.index',compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //validate the request
        $this->validate($request,[
            'title' => 'required',
            'body' => 'required',
            'channel_id' => 'required|exists:channels,id'
        ]);
        
      //Create a new instance of thread  
      $thread = Thread::create([
            'user_id' => auth()->id(),
            'channel_id' => request('channel_id'),
            'title' => request('title'),
            'body' => request('body')
        ]);
        Session::flash('message', 'Thread has been published');
        return redirect($thread->path());
               
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channel,Thread $thread)
    {
        $user_subscription = $thread->getIsSubscribedToAttribute();
        return view('threads.show',[
            'thread' => $thread,
            'replies' => $thread->replies()->paginate(25),
            'subscription' =>$user_subscription
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit($channel,Thread $thread)
    {
        
        $this->authorize('update',$thread);

        return view('threads.edit')->with('channel',$channel)->with('thread',$thread);
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        $this->authorize('update',$thread);
        
        //validate the request
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'channel_id' => 'required|exists:channels,id'
        ]);

        //update the thread
        $thread->update([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'channel_id' => $request->input('channel_id')
        ]);

        $thread->refresh();

        return redirect($thread->path())
        ->with('flash',"Thread has been updated");
            
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy($channel,Thread $thread)
    {
       
        $this->authorize('update',$thread);

        $thread->delete();

        if(request()->wantsJson()){
            return response([],204);
        }

        return redirect('/threads');
    }
}
