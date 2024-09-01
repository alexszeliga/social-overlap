<?php

namespace Test\Feature\Livewire\Components\Comment;

use App\Events\CommentCreated;
use App\Jobs\InsertComment;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Livewire\Volt\Volt;
use Livewire\Livewire;
use Tests\TestCase;

class FormTest extends TestCase {
    public User $user;
    public Comment $comment;
    protected function setUp() : void 
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->comment = Comment::factory()->create();
    }

    public function testSubmittingFormQueuesInsertCommentJob() {
        Queue::fake();
        Volt::actingAs($this->user)
            ->test('components.comment.form', ['conversation' => $this->comment->conversation, 'root' => $this->comment])
            ->set('body', 'A comment body text')
            ->call('submit');
        Queue::assertPushed(InsertComment::class, 1);
    }

    public function testInsertCommentJobInsertsComment() {
        $bodyText = 'lorem ipsum dolor sit amet';
        $job = new InsertComment($this->comment->conversation,$this->user, $this->comment, $bodyText);
        $job->handle();
        $comment = Comment::where([
            ['user_id','=', $this->user->id],
            ['commentable_id', '=', $this->comment->id],
        ])->sole();
        $this->assertInstanceOf(Comment::class, $comment);
        $this->assertEquals($comment->body, $bodyText);
    }

    public function testInsertingCommentBroadcastsToCommentRootModel() {
        Event::fake();
        Volt::actingAs($this->user)
            ->test('components.comment.form', ['conversation' => $this->comment->conversation, 'root' => $this->comment])
            ->set('body', 'A comment body text')
            ->call('submit');
        Event::assertDispatched(CommentCreated::class, function ($event) {
            return $event->rootId === $this->comment->id;
        });
    }
}