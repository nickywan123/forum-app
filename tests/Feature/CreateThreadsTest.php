<?php

namespace Tests\Feature;

use App\Activity;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;


class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    

     /**
     * A basic feature test example.
     *
     * @test
     */
    function a_guest_may_not_create_a_thread(){
        // $this->withoutExceptionHandling();
        // $this->expectException('Illuminate\Auth\AuthenticationException');
        // $thread = factory('App\Thread')->make();

        // $this->post('/threads', $thread->toArray())->assertRedirect('/login');

        //$this->withoutExceptionHandling();
       // $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->get('/threads/create')->assertRedirect('/login');


        $this->post('/threads')->assertRedirect('/login');
    
    }

    /**
     * A basic feature test example.
     *
     * @test
     */
    function an_authenticated_user_may_create_a_new_thread(){
        //$this->withoutExceptionHandling();
        //Given an authenticated user
        $this->actingAs(factory('App\User')->create());

        //Create a new thread
        $thread = factory('App\Thread')->make();

        $response = $this->post('/threads', $thread->toArray());

        //Then when we visit the thread

        $this->get($response->headers->get('Location'))
        ->assertSee($thread->title)
        ->assertSee($thread->body);
    }

    /** @test */
    function a_thread_requires_a_title(){
       
       $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    function a_thread_requires_a_body(){
       
        $this->publishThread(['body' => null])
             ->assertSessionHasErrors('body');
     }

     /** @test */
     function a_thread_requires_a_valid_channel(){
         $channel = factory('App\Channel',2)->create();
         
         $this->publishThread(['channel_id' => null])
             ->assertSessionHasErrors('channel_id');

             $this->publishThread(['channel_id' => 212])
             ->assertSessionHasErrors('channel_id');

     }

    function publishThread($override =[]){
        $this->actingAs(factory('App\User')->create());

        $thread = factory('App\Thread')->make($override);
        //dd($thread);

        return $this->post('/threads', $thread->toArray());
    }

    /** @test */

    function an_authorized_user_can_delete_a_thread(){
        // User is signed in
        $this->actingAs(factory('App\User')->create());

        //Create a thread
        $thread = factory('App\Thread')->create(['user_id'=> auth()->id()]);

        //Create reply associated with the thread

        $reply = factory('App\Reply')->create(['thread_id'=>$thread->id]);

        //Delete request
        $response = $this->json('delete', $thread->path());

        $response->assertStatus(204);

        //Assert database has deleted the thread
        // Thread is deleted
        $this->assertDatabaseMissing('threads',['id'=>$thread->id]);

        //Replies is deleted
        $this->assertDatabaseMissing('replies',['id'=>$reply->id]);

        $this->assertEquals(0,Activity::count());



    }

    /** @test */
    function unauthorized_user_cannot_delete_a_thread(){

        $this->withExceptionHandling();
        //Create a thread
        $thread = factory('App\Thread')->create();

        //Delete request
        $response = $this->delete($thread->path());

        $response->assertRedirect('/login');

        $this->actingAs(factory('App\User')->create());

        $response = $this->delete($thread->path())->assertStatus(403);
    }

    
}
