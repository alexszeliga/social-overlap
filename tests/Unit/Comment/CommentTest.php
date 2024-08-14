<?php

namespace Tests\Unit\Comment;

use Tests\TestCase;
use App\Models\Comment;

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
}