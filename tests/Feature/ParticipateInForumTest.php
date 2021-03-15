<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Auth\AuthenticationException;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *  @test
     * */
    public function unauthenticated_users_may_not_add_reply(){
        
        
         //$this->withoutExceptionHandling();
        //  $this->expectException(AuthenticationException::class);
        //  $this->withoutExceptionHandling();
    
         $this->withExceptionHandling()->post('/threads/some-channel/1/replies', [])
            ->assertRedirect(route('login'));
       
    }

     /**
     * A basic feature test example.
     * @test
     * 
     */
    public function an_authenticated_user_may_participate_in_a_thread(){
        //Given we have an authenticated user
        //$user = factory('App\User')->create();
        $this->be($user = factory('App\User')->create());
        //And an existing thread
        $thread = factory('App\Thread')->create();

        //When the user adds a reply to the thread
        $reply = factory('App\Reply')->make();

        $this->post($thread->path().'/replies', $reply->toArray());

        //then their reply should be visible on the page
        $this->get($thread->path())->
        assertSee($reply->body);
    }

    /** @test */
    function a_reply_requires_a_body(){
        $this->actingAs(factory('App\User')->create());

        $thread = factory('App\Thread')->create();
        $reply = factory('App\Reply')->make(['body'=> null]);

        $this->post($thread->path().'/replies', $reply->toArray())
             ->assertSessionHasErrors('body');

    }
    /** @test */
    function unauthorized_user_cannot_delete_reply(){

        $this->withExceptionHandling();
        //Given we have a reply
        $reply= factory('App\Reply')->create();

        //Submit a delete request
        $this->delete("replies/{$reply->id}")
            ->assertRedirect('/login');

        $this->actingAs(factory('App\User')->create())
                ->delete("replies/{$reply->id}")
                ->assertStatus(403);
        
    }

    /** @test */
    function authorized_user_can_delete_reply(){

        $this->actingAs(factory('App\User')->create());

        $reply= factory('App\Reply')->create(['user_id'=> auth()->id()]);

        //Submit a delete request
        $this->delete("replies/{$reply->id}")->assertStatus(302);


        $this->assertDatabaseMissing('replies',['id'=>$reply->id]);

    }
}
