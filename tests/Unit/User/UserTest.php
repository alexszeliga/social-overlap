<?php

namespace Tests\Unit\User;

use Tests\TestCase;
use App\Models\User;
use App\Models\Community;
use App\Models\CommunityContribution;
use App\Models\Contribution;

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

    public function testUserCommunitiesDoesntIncludeSoftDeletedCommunities() {
        $community = $this->user->communities->sole();
        $this->user->disownCommunity($community);
        $this->user->refresh();
        $this->assertFalse($this->user->communities->contains($community));
    }

    public function testHomepageQueryReturnsClaimedCommunityConversations() {
        $conversation = CommunityContribution::factory()->create([
            'community_id' => $this->claimedCommunity->id,
        ]);
        $this->assertTrue($this->user->homepageQuery()->get()->contains($conversation));
    }

    public function testUserCanGetContributions() {
        $contribution = Contribution::factory()->create([
            'user_id' => $this->user->id,
        ]);
        $this->assertTrue($this->user->contributions->contains($contribution));
    }

    public function testUserCanGetOwnConversations() {
        $contribution = Contribution::factory()->create([
            'user_id' => $this->user->id,
        ]);
        $conversation = CommunityContribution::factory()->create([
            'community_id' => $this->claimedCommunity->id,
            'contribution_id' => $contribution->id,
        ]);
        $this->assertTrue($this->user->conversations->contains($conversation));
    }
}