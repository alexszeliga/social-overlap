<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\TurnType;

class TurnProcessed implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public User $user;
    public TurnType $type;
    public string $rootId;
    public string $rootClass;

    /**
     * Create a new event instance.
     */
    public function __construct(
        User $user,
        TurnType $type,
        string $rootId,
        string $rootClass
    )
    {
        $this->user = $user;
        $this->type = $type;
        $this->rootId = $rootId;
        $this->rootClass = $rootClass;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel
     */
    public function broadcastOn(): Channel
    {
        return new Channel('turn.'.$this->rootId); 
    }
}
