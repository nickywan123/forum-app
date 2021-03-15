<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','facebook_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
 * Get the route key for the model.
 *
 * @return string
 */
public function getRouteKeyName()
{
    return 'name';
}

// An user has many threads
public function threads(){
    return $this->hasMany('App\Thread','user_id')->latest();
}

// A user have many activities

public function activity(){
    return $this->hasMany('App\Activity');
}

//User have many subscriptions
public function subscriptions(){
    return $this->hasMany('App\ThreadSubscription','user_id');
}

public function lastReply(){
    return $this->hasOne(Reply::class)->latest();
}

}
