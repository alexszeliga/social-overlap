<?php

namespace Tests\Unit\Turn;
use Tests\TestCase;
use App\Models\Turn;
use App\Models\TurnType;

class TurnTest extends TestCase {
    protected $turn;

    protected function setUp() : void {
        parent::setUp();
        $this->turn = Turn::factory()->create();
    }

    public function testBasicCreation() {
        $this->assertInstanceOf(Turn::class, $this->turn);
    }

    public function testCanReturnValueOfTurnType() {
        $supportTurn = Turn::factory()->create([
            'turn_type_id' => TurnType::factory()->support()->create()->id,
        ]);

        $this->assertEquals($supportTurn->getValue(), 1);

        $dissentTurn = Turn::factory()->create([
            'turn_type_id' => TurnType::factory()->dissent()->create()->id,
        ]);

        $this->assertEquals($dissentTurn->getValue(), -1);
    }
}