<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reply extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    protected $with = ['owner','favorites'];

    protected $appends = ['favorites_count','isFavorited'];

    public static function boot()
    {
        parent::boot();
        //Delete favorited reply if reply is deleted
        static::deleting(function ($reply) {
            $reply->favorites->each->delete();
        });
    }

    public function owner(){
        return $this->belongsTo('App\User','user_id');
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
        $attributes = ['user_id'=>auth()->id()];

        if($this->favorites()->where($attributes)->exists()){
            return $this->favorites()->where($attributes)->delete();
        }

    }

    public function isFavorited(){

        return  $this->favorites->where('user_id',auth()->id())->count();
    }

    public function getIsFavoritedAttribute(){
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute(){
        return $this->favorites->count();
    }
    public function thread(){
        return $this->belongsTo('App\Thread');
    }
    public function path(){
        return $this->thread->path()."#reply-{$this->id}";
    }

    public function wasJustPublished(){
        return $this->created_at->gt(Carbon::now()->subMinute());
    }
}
