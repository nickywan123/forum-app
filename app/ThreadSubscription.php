<?php

namespace App;

use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Model;

class ThreadSubscription extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function thread(){
        return $this->belongsTo('App\Thread');
    }

    public function notify($reply)
    {
        $this->user->notify(new ThreadWasUpdated($this->thread, $reply));
    }
}
