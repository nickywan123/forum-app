<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         'App\Thread' => 'App\Policies\ThreadPolicy',
         'App\Reply' => 'App\Policies\ReplyPolicy',
         'App\User' => 'App\Policies\UserPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Allow Nicholas as admin to delete any threads
        // Gate::before(function($user){
        //     if($user->name === 'Nicholas'){
        //         return true;
        //     }
        // });
    }
}
