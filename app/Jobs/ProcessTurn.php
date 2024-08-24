<?php

namespace App\Jobs;

use App\Events\TurnProcessed;
use App\Models\Turn;
use App\Models\TurnType;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessTurn implements ShouldQueue
{
    use Queueable;


    /**
     * Create a new job instance.
     */
    public function __construct(
        public TurnType $turnType,
        public User $user,
        public Model $root
    )
    {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $turn = Turn::withTrashed()->firstOrNew([
            'user_id' => $this->user->id,
            'turnable_id' => $this->root->id,
            'turnable_type' => $this->root::class
        ]);
        if ($this->turnType->id === $turn->turn_type_id) {
            $turn->trashed() ? $turn->restore() : $turn->delete(); 
        }
        $turn->turn_type_id = $this->turnType->id;
        if ($turn->isDirty()) {
            $turn->trashed() ? $turn->restore() : $turn->save();
        }
        TurnProcessed::dispatch($this->root->id);
    }
}
