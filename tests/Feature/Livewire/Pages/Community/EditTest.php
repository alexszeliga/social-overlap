<?php

namespace Test\Feature\Livewire\Pages\Community;

use App\Models\User;
use App\Models\Community;

use Livewire\Volt\Volt;
use Livewire\Livewire;
use Tests\TestCase;

class EditTest extends TestCase {
    public User $user;
    public Community $community;
    protected function setUp() : void {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->community = Community::factory()->create();
        $this->user->claimCommunity($this->community);
    }

    public function testUserCanCreateACommunityWithWebForm() {
        $name = 'New Community';
        $desc = 'A brand new community';
        Volt::actingAs($this->user)
            ->test('pages.community.edit')
            ->set('name', $name)
            ->set('description', $desc)
            ->call('save');
        $community = Community::where('name', $name)->sole();
        $this->assertInstanceOf(Community::class, $community);
        $this->assertEquals($desc, $community->description);
    }

}