<?php

namespace Tests\Unit\User;

use Tests\TestCase;
use App\Models\User;
use App\Models\Community;

class UserTest extends TestCase
{
    protected $user;

    protected function setUp() : void {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function testBasicCreation() {
        $this->assertInstanceOf(User::class, $this->user);
    }
    
    public function testUserCanClaimCommunity() {
        $community = Community::factory()->create();
        $this->user->communities()->attach($community);
        $this->assertTrue($this->user->communities->contains($community->id));
    }
}