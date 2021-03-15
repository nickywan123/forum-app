<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Channel;
use Illuminate\Filesystem\Cache;
use Illuminate\Support\Facades\Cache as IlluminateCache;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
          // Using Closure based composers...
          View::composer('*', function ($view) {
              $channels= IlluminateCache::rememberForever('channels',function(){
                return Channel::all();
              });
            $view->with('channels',$channels); 
        });
    }
}
