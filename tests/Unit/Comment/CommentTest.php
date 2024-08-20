<?php

namespace Tests\Unit\Comment;

use Tests\TestCase;
use App\Models\Comment;
use App\Models\CommunityContribution;
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
            'community_contribution_id' => $this->comment->conversation->id,
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
        $conversation = CommunityContribution::factory()->create();
        $comment = Comment::factory()->create([
            'community_contribution_id' => $conversation->id,
        ]);
        $this->assertTrue($comment->conversation->is($conversation));
    }

    public function testBranchCommentsAreReturnedMostRecentFirst() {
        $earlyComment = Comment::factory()->create([
            'community_contribution_id' => $this->comment->conversation->id,
            'commentable_id' => $this->comment->id,
            'commentable_type' => $this->comment::class,
            'created_at' => Carbon::now()->subHour(),
        ]);
        $recentComment = Comment::factory()->create([
            'community_contribution_id' => $this->comment->conversation->id,
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
            'turn_type_id' => TurnType::factory()->support()->create()->id,
        ]);

        $this->assertEquals($this->comment->getScore(), 1);
    }

    public function testCanReturnRootModel() {
        $branchComment = Comment::factory()->create([
            'community_contribution_id' => $this->comment->conversation->id,
            'commentable_id' => $this->comment->id,
            'commentable_type' => $this->comment::class,
        ]);
        $this->assertTrue($branchComment->root->is($this->comment));
    }

    public function testKnowsIfUserHasTurned() {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $turn1 = Turn::factory()->create([
            'user_id' => $user1->id,
            'turnable_id' => $this->comment->id,
            'turnable_type' => $this->comment::class,
            'turn_type_id' => TurnType::factory()->support()->create()->id,
        ]);
        $this->assertTrue($this->comment->userHasTurned($user1));
        $this->assertFalse($this->comment->userHasTurned($user2));
    }
}