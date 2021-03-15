<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{

/**
 * Get the route key for the model.
 *
 * @return string
 */
    public function getRouteKeyName()
    {
        return 'slug';
    }


    public function threads(){
        return $this->hasMany('App\Thread');
    }
}
