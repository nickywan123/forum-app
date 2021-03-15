<?php

namespace App;

use App\Activity;
use App\Events\ThreadReceivedNewReply;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use ReflectionClass;

class Thread extends Model
{
    use RecordsActivity,Searchable;

    protected $guarded = [];

    protected $with = ['creator','channel'];

    protected $appends = ['isSubscribedTo','favorites_count','isFavorited'];

    // Global scope return replies count
    protected static function boot(){
        parent::boot();

        static::addGlobalScope('replyCount',function ($builder){
            $builder->withCount('replies');
        });

        static::deleting(function($thread){
            $thread->replies->each->delete();
            $thread->favorites->each->delete();
        });
        
    }
    
     /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {  
        // Customize array...

        return $this->only(['id','title', 'body']);
    }

    // return a single thread
    public function path(){
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    //return replies associated with a thread
    public function replies(){
        return $this->hasMany('App\Reply');
    }

    //return creator of the thread
    public function creator(){
        return $this->belongsTo('App\User','user_id');
    }

    public function addReply($data){
        $reply = $this->replies()->create($data);
 
        event(new ThreadReceivedNewReply($reply));
 
        return $reply;
    }

    //Each thread belongs to a channel
    public function channel(){
        return $this->belongsTo('App\Channel');
    }

    public function scopeFilter($query, $filters){
        return $filters->apply($query);
    }

    public function subscriptions(){
        return $this->hasMany('App\ThreadSubscription');
    }

    
    public function subscribe(){
        $this->subscriptions()->create([
             'user_id' => auth()->id()
         ]);
    }

    public function unsubscribe(){

        $this->subscriptions()
            ->where('user_id',auth()->id())
            ->delete();
    }

    //check if user is subscribed to thread
    public function getIsSubscribedToAttribute(){
        return $this->subscriptions()
        ->where('user_id', auth()->id())
        ->exists();
    }

    public function favorites(){
        return $this->morphMany('App\Favorite','favorited');
    }

    public function favorite(){

        $attributes = ['user_id'=>auth()->id()];
        if(! $this->favorites()->where($attributes)->exists()){
            return $this->favorites()->create($attributes);
        }
    }
    public function unfavorite(){
        //$attributes = ['user_id'=>auth()->id()];
        if($this->favorites()->where('user_id',auth()->id())->exists()){
            return $this->favorites()->where('user_id',auth()->id())->delete();
        }
    }

    public function isFavorited(){

        return $this->favorites->where('user_id',auth()->id())->count();
    }

    public function getIsFavoritedAttribute(){
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute(){
        return $this->favorites->count();
    }
}
