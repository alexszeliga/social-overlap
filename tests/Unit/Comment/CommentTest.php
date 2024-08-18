<?php

namespace Tests\Unit\Comment;

use Tests\TestCase;
use App\Models\Comment;
use App\Models\CommunityContribution;
use App\Models\User;
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
}