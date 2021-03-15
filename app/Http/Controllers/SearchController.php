<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request){
       
        $threads = Thread::search($request->input('search'))->get();
       

        return view('threads.index',compact('threads'));

    }
}
