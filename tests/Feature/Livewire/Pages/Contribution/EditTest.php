<?php

namespace Test\Feature\Livewire\Pages\Contribution;

use App\Models\Community;
use App\Models\Contribution;
use App\Models\Conversation;
use App\Models\User;

use Livewire\Volt\Volt;
use Livewire\Livewire;
use Tests\TestCase;

class EditTest extends TestCase {
    protected Community $community;
    public User $user;

    protected function setUp() : void {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->community = Community::factory()->create();
        $this->user->claimCommunity($this->community);
    }

    public function testWhenAUserCreatesAConversationTheySupportItByDefault() {
        Volt::actingAs($this->user)
            ->test('pages.contribution.edit')
            ->set('slug', $this->community->slug)
            ->set('url', 'https://www.example.com')
            ->set('name', 'An Example Website')
            ->call('save');
        $contribution = Contribution::where('url', 'https://www.example.com')
                                    ->where('user_id', $this->user->id)
                                    ->sole();
        $conversation = Conversation::where('community_id', $this->community->id)
                                    ->where('contribution_id', $contribution->id)
                                    ->sole();
        $this->assertTrue($conversation->userHasTurned($this->user));
        print($conversation->getUserSupportTypeName($this->user));

    }

}