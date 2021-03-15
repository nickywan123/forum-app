<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;
    protected $thread;

    public function setUp():void{
        parent::setUp();
        $this->thread = factory('App\Thread')->create();
    }

    /**
     * A basic unit test example.
     *
     * @test
     */
    public function a_thread_can_add_reply(){
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1
        ]);
        $this->assertCount(1,$this->thread->replies);

    }

    /** @test */
    function a_thread_belongs_to_a_channel(){
        $this->thread;
       // $thread = factory('App\Thread')->create();
        $this->assertInstanceOf('App\Channel', $this->thread->channel);
    }

    /** @test */
    function a_thread_can_make_a_string_path(){
        $thread = factory('App\Thread')->create();
        $this->assertEquals("/threads/{$thread->channel->slug}/{$thread->id}",$thread->path());
        
    }
}
