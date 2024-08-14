<?php

namespace Tests\Unit\Community;

use Tests\TestCase;
use App\Models\Community;
use App\Models\Contribution;
use App\Models\User;

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

    public function testCommunityKnowsIfUserIsSubscribed() {
        $user = User::factory()->create();
        $this->assertFalse($this->community->userIsSubscribed($user));
        $user->communities()->attach($this->community);
        $this->community->refresh();
        $this->assertTrue($this->community->userIsSubscribed($user));
    }

    public function testCanGetContributionsFromUsers() {
        $user = User::factory()->create();
        $contribution = Contribution::factory()->create([
            'user_id' => $user->id,
            'url' => 'https://google.com/',
        ]); 
        $contribution->addCommunity($this->community);
        $this->community->refresh();
        $this->assertTrue($this->community->contributions->contains($contribution));
    }
    
}