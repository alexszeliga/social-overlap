<?php

namespace Tests\Unit\User;

use Tests\TestCase;
use App\Models\User;
use App\Models\Community;
use App\Models\CommunityUser;
use App\Models\Contribution;

class CommunityUserTest extends TestCase
{
    protected $cu;

    protected function setUp() : void {
        parent::setUp();
        $this->cu = CommunityUser::factory()->create();
    }

    public function testBasicCreation() {
        $this->assertInstanceOf(CommunityUser::class, $this->cu);
    }

    public function testCanReturnRelations() {
        $user = User::factory()->create();
        $community = Community::factory()->create();
        $newCu = CommunityUser::factory()->create([
            'user_id' => $user->id,
            'community_id' => $community->id,
        ]);

        $this->assertTrue($newCu->user->is($user));
        $this->assertTrue($newCu->community->is($community));
    }
   
}