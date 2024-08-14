<?php

namespace Tests\Unit\CommunityContribution;

use Tests\TestCase;
use App\Models\Community;
use App\Models\CommunityContribution;
use App\Models\Contribution;

class CommunityContributionTest extends TestCase
{
    protected $conversation;

    protected function setUp() : void {
        parent::setUp();
        $cont = Contribution::factory()->create();
        $com = Community::factory()->create();
        $cont->addCommunity($com);
        $this->conversation = CommunityContribution::where('contribution_id', '=', $cont->id)
                                                   ->where('community_id', '=', $com->id)
                                                   ->sole();
    }

    public function testBasicCreation() {
        $this->assertInstanceOf(CommunityContribution::class, $this->conversation);
    }
}