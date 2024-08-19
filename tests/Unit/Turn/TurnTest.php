<?php

namespace Tests\Unit\Turn;
use Tests\TestCase;
use App\Models\Turn;

class TurnTest extends TestCase {
    protected $turn;

    protected function setUp() : void {
        parent::setUp();
        $this->turn = Turn::factory()->create();
    }

    public function testBasicCreation() {
        $this->assertInstanceOf(Turn::class, $this->turn);
    }
}