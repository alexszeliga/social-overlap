<?php

namespace Test\Feature\Livewire\Components\Turn;

use App\Models\User;
use App\Models\Turn;
use App\Models\TurnType;
use App\Models\Community;
use App\Models\CommunityContribution;
use App\Models\Contribution;
use App\Jobs\ProcessTurn;

use Illuminate\Support\Facades\Queue;

use Livewire\Volt\Volt;
use Livewire\Livewire;
use Tests\TestCase;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class ToggleTest extends TestCase {
    public Model $root;
    public User $user;

    protected function setUp() : void {
        parent::setUp();
        $this->user = User::factory()->create();
        $community = Community::factory()->create();
        $contribution = Contribution::factory()->create([
            'user_id' => $this->user->id
        ]);
        $this->root = CommunityContribution::factory()->create([
            'community_id' => $community->id,
            'contribution_id' => $contribution->id,
        ]);
    }

    public function testTogglingTurnQueuesTurnJob() {
        Queue::fake();
        $support = TurnType::find(TurnType::SUPPORT);
        Volt::actingAs($this->user)
            ->test('components.turn.toggle', ['root' => $this->root])
            ->call('toggleTurn', type: $support->id);
        Queue::assertPushed(ProcessTurn::class, 1);
    }

    public function testProcessTurnInsertsTurn() {
        DB::beginTransaction();        
        $support = TurnType::find(TurnType::SUPPORT);
        $job = new ProcessTurn($support, $this->user, $this->root);
        $job->handle();
        $turn = Turn::where('user_id', $this->user->id)->where('turnable_id', $this->root->id)->sole();
        $this->assertInstanceOf(Turn::class, $turn);
        DB::rollback();
    }

    public function testProcessTurnScoreDelta() {
        DB::beginTransaction();
        $this->assertEquals($this->root->getScore(), 0);
        $support = TurnType::find(TurnType::SUPPORT);
        $dissent = TurnType::find(TurnType::DISSENT);
        $job1 = new ProcessTurn($support, $this->user, $this->root);
        $job1->handle();
        $this->root->refresh();
        $this->assertEquals($this->root->getScore(), 1);
        $job2 = new ProcessTurn($support, $this->user, $this->root);
        $job2->handle();
        $this->root->refresh();
        $this->assertEquals($this->root->getScore(), 0);
        $job3 = new ProcessTurn($support, $this->user, $this->root);
        $job3->handle();
        $this->root->refresh();
        $this->assertEquals($this->root->getScore(), 1);
        $job4 = new ProcessTurn($dissent, $this->user, $this->root);
        $job4->handle();
        $this->root->refresh();
        $this->assertEquals($this->root->getScore(), -1);
        $user2 = User::factory()->create();
        $job5 = new ProcessTurn($dissent, $user2, $this->root);
        $job5->handle();
        $this->root->refresh();
        $this->assertEquals($this->root->getScore(), -2);
        DB::rollback();
    }
}