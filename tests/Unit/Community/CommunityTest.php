<?php

namespace Tests\Unit\Community;

use Tests\TestCase;
use App\Models\Community;

class CommunityTest extends TestCase
{
    protected $community;

    protected function setUp() : void {
        parent::setUp();
        $this->community = Community::factory()->create();
    }

    public function testBasicCreation() {
        $this->assertInstanceOf(Community::class, $this->community);
    }
    
}