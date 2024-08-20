<?php

namespace Tests\Unit\Turn;
use Tests\TestCase;
use App\Models\Comment;
use App\Models\Turn;
use App\Models\TurnType;

class TurnTest extends TestCase {
    protected $turn;
    protected $root;
    protected function setUp() : void {
        parent::setUp();
        $this->root = Comment::factory()->create();
        $this->turn = Turn::factory()->create([
            'turnable_id' => $this->root->id,
            'turnable_type' => $this->root::class,
        ]);
    }

    public function testBasicCreation() {
        $this->assertInstanceOf(Turn::class, $this->turn);
    }

    public function testCanReturnValueOfTurnType() {
        $supportTurn = Turn::factory()->create([
            'turn_type_id' => TurnType::find(TurnType::SUPPORT)->id,
        ]);

        $this->assertEquals($supportTurn->getValue(), 1);

        $dissentTurn = Turn::factory()->create([
            'turn_type_id' => TurnType::find(TurnType::DISSENT)->id,
        ]);

        $this->assertEquals($dissentTurn->getValue(), -1);
    }

    public function testCanReturnRoot() {
        $this->assertInstanceOf(Comment::class, $this->turn->root);
    }
}