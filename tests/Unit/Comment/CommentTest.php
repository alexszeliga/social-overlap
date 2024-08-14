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
}