<?php

namespace Tests\Unit\User;

use Tests\TestCase;
use App\Models\User;
use App\Models\Community;

class UserTest extends TestCase
{
    protected $user;
    protected $claimedCommunity;

    protected function setUp() : void {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->claimedCommunity = Community::factory()->create();
        $this->user->claimCommunity($this->claimedCommunity);
    }

    public function testBasicCreation() {
        $this->assertInstanceOf(User::class, $this->user);
    }
    
    public function testUserCanClaimCommunity() {
        $this->assertTrue($this->user->communities->contains($this->claimedCommunity->id));
    }
}