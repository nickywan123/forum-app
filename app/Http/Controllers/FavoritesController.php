<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Reply;
use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavoritesController extends Controller
{
    
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function store(Reply $reply){
        $reply->favorite();
        return back();     
    }

    public function destroy(Reply $reply){
        $reply->unfavorite();

    }

    public function storeThreads(Thread $thread){
        $thread->favorite();
        return back();
    }

    public function destroyThreads(Thread $thread){
        $thread->unfavorite();
    }

}
