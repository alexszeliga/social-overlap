<?php

namespace Test\Feature\Livewire\Pages\Community;

use App\Models\User;
use App\Models\Community;

use Livewire\Volt\Volt;
use Livewire\Livewire;
use Tests\TestCase;

class CreateTest extends TestCase {
    public User $user;
    public Community $community;
    protected function setUp() : void {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->community = Community::factory()->create();
        $this->user->claimCommunity($this->community);
    }

    public function testUserCanCreateACommunityWithWebForm() {
        $name = 'Some Other Place';
        $desc = 'A time honored traditional community';
        $community = $this->createCommunity($name, $desc);
        $this->assertInstanceOf(Community::class, $community);
        $this->assertEquals($desc, $community->description);
    }

    public function testWhenAUserCreatesACommunityTheyClaimItByDefault() {
        $community = $this->createCommunity();
        $this->assertTrue($community->userIsSubscribed($this->user));
    }

    private function createCommunity($name = 'New Community', $desc = 'A brand new community') {
        Volt::actingAs($this->user)
            ->test('pages.community.create')
            ->set('name', $name)
            ->set('description', $desc)
            ->call('save');
        return Community::where('name', $name)->sole();
    }

}