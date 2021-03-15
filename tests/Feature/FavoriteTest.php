<?php

namespace Tests\Feature;

use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoriteTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function guest_can_not_favourite_reply(){
        $this->withExceptionHandling();
        $this->post('replies/1/favorites')
            ->assertRedirect('/login');
    }

    /** @test */
    function an_authenticated_user_can_favorite_reply(){
        //$this->withExceptionHandling();
        $this->be($user = factory('App\User')->create());
        // Create a new reply
        $reply = factory('App\Reply')->create();

        //Post request for reply
        $this->post('replies/'.$reply->id.'/favorites');

        //Check assertion to db success or not

        $this->assertCount(1, $reply->favorites);

    }

    /** @test */
    function an_authenticated_user_can_favorite_reply_once(){
        //Signed in user
        $this->be($user = factory('App\User')->create());
        // Create a new reply
        $reply = factory('App\Reply')->create();

        //Post request for reply
       try{
        $this->post('replies/'.$reply->id.'/favorites');
        $this->post('replies/'.$reply->id.'/favorites');
       }catch(Exception $e){
        $this->fail('User tried to favorite more than once');
       }

        //Check assertion to db success or not

        $this->assertCount(1, $reply->favorites);

    }
    
}
