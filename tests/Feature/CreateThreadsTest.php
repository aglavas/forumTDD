<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Auth\AuthenticationException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function an_auth_user_can_create_new_forum_threads()
    {

        $this->signIn();
        /** @var Thread $thread */

        $thread = make(Thread::class);

        $this->post('/threads', $thread->toArray());

        $this->get($thread->path())->assertSee($thread->body)->assertSee($thread->title);

    }

    /**
     * @test
     */
    public function guests_cannot_see_the_create_thread_page()
    {
        $this->get('threads/create')
            ->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function guests_may_not_create_threads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = make(Thread::class);

        $this->post('/threads', $thread->toArray());
    }
}
