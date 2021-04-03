<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfilesTest extends TestCase
{

    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @test
     */
    function a_user_has_a_profile(){

        $this->withoutExceptionHandling();
        // Create a user instance
        
        $user = factory('App\User')->create();

        $this->actingAs($user);

        //dd($user);

        // Get the profile request
        $this->get("/profile/{$user->name}")
            ->assertSee($user->name);
    }

    /** @test */
    function a_profile_display_all_threads_associated_with_a_user(){
        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());
       

        $thread = factory('App\Thread')->create(['user_id'=>auth()->id()]);

        // Get the profile request
        $this->get("/activities/" . auth()->user()->name)
            ->assertSee($thread->title)
            ->assertSee($thread->body);

    }
    
}
