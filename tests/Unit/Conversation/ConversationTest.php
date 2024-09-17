<?php

namespace Tests\Unit\Conversation;

use Tests\TestCase;
use App\Models\Community;
use App\Models\Conversation;
use App\Models\Contribution;
use App\Models\Comment;
use App\Models\Turn;
use App\Models\TurnType;
use App\Models\User;
use Carbon\Carbon;

class ConversationTest extends TestCase
{
    protected $conversation, $contribution;

    protected function setUp() : void {
        parent::setUp();
        $this->contribution = Contribution::factory()->create();
        $com = Community::factory()->create();
        $this->contribution->addCommunity($com);
        $this->conversation = Conversation::where('contribution_id', '=', $this->contribution->id)
                                                   ->where('community_id', '=', $com->id)
                                                   ->sole();
    }

    public function testBasicCreation() {
        $this->assertInstanceOf(Conversation::class, $this->conversation);
    }

    public function testCanAttachRootComments() {
        $comment = Comment::factory()->create([
            'conversation_id' => $this->conversation->id,
            'commentable_id' => $this->conversation->id,
            'commentable_type' => $this->conversation::class
        ]);
        $this->assertTrue($this->conversation->comments->contains($comment));
    }

    public function testRootCommentsAreReturnedMostRecentFirst() {
        $earlyComment = Comment::factory()->create([
            'conversation_id' => $this->conversation->id,
            'commentable_id' => $this->conversation->id,
            'commentable_type' => $this->conversation::class,
            'created_at' => Carbon::now()->subHour(),
        ]);
        $recentComment = Comment::factory()->create([
            'conversation_id' => $this->conversation->id,
            'commentable_id' => $this->conversation->id,
            'commentable_type' => $this->conversation::class,
            'created_at' => Carbon::now(),
        ]);
        $this->assertTrue($this->conversation->comments->first()->is($recentComment));
    }
    
    public function testCanReturnTurns() {
        $turn = Turn::factory()->create([
            'turnable_id' => $this->conversation->id,
            'turnable_type' => $this->conversation::class,
        ]);
        $this->assertTrue($this->conversation->turns->contains($turn));
    }

    public function testCanGetScoreFromTurns() {
        $this->assertEquals($this->conversation->getScore(), 1);
        $turn1 = Turn::factory()->create([
            'turnable_id' => $this->conversation->id,
            'turnable_type' => $this->conversation::class,
            'turn_type_id' => TurnType::support()->id,
        ]);
        $this->conversation->refresh();
        $this->assertEquals($this->conversation->getScore(), 2);
    }

    public function testCanReturnContribution() {
        $this->assertTrue($this->contribution->is($this->conversation->contribution));
    }

    
    public function testKnowsIfUserHasTurned() {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $turn1 = Turn::factory()->create([
            'user_id' => $user1->id,
            'turnable_id' => $this->conversation->id,
            'turnable_type' => $this->conversation::class,
            'turn_type_id' => TurnType::support()->id,
        ]);
        $this->assertTrue($this->conversation->userHasTurned($user1));
        $this->assertFalse($this->conversation->userHasTurned($user2));
    }
}