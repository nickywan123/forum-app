<?php 

namespace App\Filters;

use App\User;

class ThreadFilters extends Filters{

    protected $filters = ['by','popular'];
    /** Filter a query by a username
     * @param string $username
     */ 

     protected function by($username){
         $user = User::where('name', $username)->firstOrFail();

         return $this->builder->where('user_id', $user->id);
     }

     /**Filter query by popularity */
     protected function popular(){
         return $this->builder->reorder('replies_count','desc');
     }

}