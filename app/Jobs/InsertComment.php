<?php

namespace App\Jobs;

use App\Events\CommentCreated;
use App\Models\Comment;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InsertComment implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Conversation $conversation,
        public User $user,
        public Model $root,
        public string $body,
    )
    {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Comment::create([
            'conversation_id' => $this->conversation->id,
            'user_id' => $this->user->id,
            'commentable_id' => $this->root->id,
            'commentable_type' => $this->root::class,
            'body' => $this->body,
        ]);
        CommentCreated::dispatch($this->root->id);
    }
}
