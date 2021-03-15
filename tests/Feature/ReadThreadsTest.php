<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;

    public function setUp():void{
        parent::setUp();
        $this->thread = factory('App\Thread')->create();
    }


    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function a_user_can_view_all_threads()
    {
        
        $thread = factory('App\Thread')->create(); 

        $response = $this->get('/threads');
        $response->assertSee($thread->title);

      
    }

     /**
     * A basic test example.
     * @test
     * @return void
     */
    public function a_user_can_read_a_single_thread()
    {
        
        $thread = factory('App\Thread')->create(); 
        $response = $this->get('/threads/' .$this->thread->id); 
        $response->assertSee($this->thread->tiitle);
    }
      
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function a_user_can_read_replies_associated_with_a_thread(){
        //Given a thread, a thread include replies
        //And that thread include replies,when we visit a thread page, we should see replies
        
        $reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]);
        
        // $this->get('/threads/'.$this->thread->id)
        // ->assertSee($reply->body);

        $this->get("/threads/{$this->thread->channel->id}/{$this->thread->id}")
        ->assertSee($reply->body);

    }

    /** @test */
    function a_user_can_filter_threads_according_to_a_channel(){
        //arrange - act - assert

        //$this->withoutExceptionHandling();
        //arrange -  set up the model
        $channel = factory('App\Channel')->create();


        $threadInChannel = factory('App\Thread')->create(['channel_id' => $channel->id]);


        $threadNotInChannel = factory('App\Thread')->create();

        //dd($threadNotInChannel);

        //act - making a request
        //assert - check thread return title or not
       $this->get('/threads/' .$channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);

    }

    /** @test */
    function a_user_can_filter_threads_by_username(){

        //arrange
        $this->actingAs(factory('App\User')->create(['name' =>'John']));

        $threadByJohn = factory('App\Thread')->create(['user_id' => auth()->id()]);

        $threadNotJohn = factory('App\Thread')->create();

        //act and assert

        $this->get('/threads?by=John')
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadNotJohn->title);
    }

    /** @test */
    function a_user_can_filter_threads_by_popularity(){
        //$this->withExceptionHandling();
        
        // Given we have three threads with 3 replies, 2 replies and 0 reply
        $threadWithThreeReplies = factory('App\Thread')->create();

        factory('App\Reply')->create(['thread_id' => $threadWithThreeReplies->id],3);

        $threadWithTwoReplies = factory('App\Thread')->create();
        factory('App\Reply')->create(['thread_id' => $threadWithTwoReplies->id],2);

        $threadWithNoReplies = $this->thread;

        //We should be able to fetch the threads page by popularity

        $response= $this->get('threads?popular=1');

        //Return threads with most replies to least reply.
        $response->assertSeeInOrder([
            $threadWithThreeReplies->title,
            $threadWithTwoReplies->title,
            $threadWithNoReplies->title
            ]);

    }
}
