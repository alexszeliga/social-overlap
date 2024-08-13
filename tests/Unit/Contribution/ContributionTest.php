<?php

namespace Tests\Unit\Contribution;

use Tests\TestCase;
use App\Models\Contribution;
use App\Models\Community;


class ContributionTest extends TestCase
{
    protected $contribution;

    protected function setUp() : void {
        parent::setUp();
        $this->contribution = Contribution::factory()->create();
    }

    public function testBasicCreation() {
        $this->assertInstanceOf(Contribution::class, $this->contribution);
    }

    public function testCanAttachToCommunityClaimedByUser() {
        $community = Community::factory()->create();
        $this->assertFalse($this->contribution->communities->contains($community));
        $this->contribution->communities()->attach($community);
        $this->contribution->refresh();
        $this->assertTrue($this->contribution->communities->contains($community));
    }
}