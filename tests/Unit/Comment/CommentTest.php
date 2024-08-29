<?php

namespace Tests\Unit\Comment;

use Tests\TestCase;
use App\Models\Comment;
use App\Models\Conversation;
use App\Models\User;
use App\Models\Turn;
use App\Models\TurnType;
use Carbon\Carbon;

class CommentTest extends TestCase
{
    protected $comment;

    protected function setUp() : void {
        parent::setUp();
        $this->comment = Comment::factory()->create();
    }

    public function testBasicCreation() {
        $this->assertInstanceOf(Comment::class, $this->comment);
    }

    public function testCanAttachBranchComment() {
        $branchComment = Comment::factory()->create([
            'conversation_id' => $this->comment->conversation->id,
            'commentable_id' => $this->comment->id,
            'commentable_type' => $this->comment::class,
        ]);
        $this->assertTrue($this->comment->comments->contains($branchComment));
    }

    public function testCanReturnUser() {
        $user = User::factory()->create();
        $comment = Comment::factory()->create([
            'user_id' => $user->id,
        ]);
        $this->assertTrue($comment->user->is($user));
    }

    public function testCanReturnConversation() {
        $conversation = Conversation::factory()->create();
        $comment = Comment::factory()->create([
            'conversation_id' => $conversation->id,
        ]);
        $this->assertTrue($comment->conversation->is($conversation));
    }

    public function testBranchCommentsAreReturnedMostRecentFirst() {
        $earlyComment = Comment::factory()->create([
            'conversation_id' => $this->comment->conversation->id,
            'commentable_id' => $this->comment->id,
            'commentable_type' => $this->comment::class,
            'created_at' => Carbon::now()->subHour(),
        ]);
        $recentComment = Comment::factory()->create([
            'conversation_id' => $this->comment->conversation->id,
            'commentable_id' => $this->comment->id,
            'commentable_type' => $this->comment::class,
            'created_at' => Carbon::now(),
        ]);
        $this->assertTrue($this->comment->comments->first()->is($recentComment));
    }

    public function testCanReturnTurns() {
        $turn = Turn::factory()->create([
            'turnable_id' => $this->comment->id,
            'turnable_type' => $this->comment::class,
        ]);
        $this->assertTrue($this->comment->turns->contains($turn));
    }

    public function testCanGetScoreFromTurns() {
        $turn1 = Turn::factory()->create([
            'turnable_id' => $this->comment->id,
            'turnable_type' => $this->comment::class,
            'turn_type_id' => TurnType::support()->id,
        ]);

        $this->assertEquals($this->comment->getScore(), 1);
    }

    public function testCanReturnRootModel() {
        $branchComment = Comment::factory()->create([
            'conversation_id' => $this->comment->conversation->id,
            'commentable_id' => $this->comment->id,
            'commentable_type' => $this->comment::class,
        ]);
        $this->assertTrue($branchComment->root->is($this->comment));
    }

    public function testKnowsIfUserHasTurned() {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        Turn::factory()->create([
            'user_id' => $user1->id,
            'turnable_id' => $this->comment->id,
            'turnable_type' => $this->comment::class,
            'turn_type_id' => TurnType::support()->id,
        ]);
        $this->assertTrue($this->comment->userHasTurned($user1));
        $this->assertFalse($this->comment->userHasTurned($user2));
    }

    public function testCanGetUserTurnType() {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();
        $support = TurnType::support();
        $dissent = TurnType::dissent();
        Turn::factory()->create([
            'user_id' => $user1->id,
            'turnable_id' => $this->comment->id,
            'turnable_type' => $this->comment::class,
            'turn_type_id' => $support->id,
        ]);
        Turn::factory()->create([
            'user_id' => $user2->id,
            'turnable_id' => $this->comment->id,
            'turnable_type' => $this->comment::class,
            'turn_type_id' => $dissent->id,
        ]);
        $this->assertEquals($this->comment->getUserSupportTypeName($user1), $support->name);
        $this->assertEquals($this->comment->getUserSupportTypeName($user2), $dissent->name);
        $this->assertEquals($this->comment->getUserSupportTypeName($user3), '');
    }
}