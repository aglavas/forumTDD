<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Auth\AuthenticationException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function an_unauthenticated_user_may_not_add_replies()
    {
        $this->expectException(AuthenticationException::class);

        $thread = factory(Thread::class)->create();

        $reply = factory(Reply::class)->create();

        $this->post($thread->path() . '/replies', $reply->toArray());
    }


    /**
     * @test
     */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->signIn();

        $thread = factory(Thread::class)->create();

        $reply = factory(Reply::class)->make();

        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);
    }
}
