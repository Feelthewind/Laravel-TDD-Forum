<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LockThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function non_administrators_may_not_lock_threads()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->post(route('locked-threads.store', $thread))->assertStatus(403);

        $this->assertFalse(!!$thread->fresh()->locked);
    }

    /** @test */
    function administrators_can_lock_threads()
    {
        $administrator = factory('App\User')->states('administrator')->create();

        $this->signIn($administrator);

        $thread = create('App\Thread');

        $this->post(route('locked-threads.store', $thread));

        $this->assertTrue(!!$thread->fresh()->locked, 'Failed asserting that the thread was locked.');
    }
}
