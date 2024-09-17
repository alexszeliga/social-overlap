<?php

namespace App\Models;

use App\Models\Conversation;
use App\Models\Turn;
use App\Models\TurnType;
use App\Turnable;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, HasUuids, SoftDeletes, Turnable;

    protected $fillable = [
        'conversation_id',
        'user_id',
        'commentable_id',
        'commentable_type',
        'body',
    ];

    public function conversation() : HasOne 
    {
        return $this->hasOne(Conversation::class, 'id', 'conversation_id');
    }

    public function root() : MorphTo 
    {
        return $this->morphTo(__FUNCTION__, 'commentable_type', 'commentable_id');
    }

    public function comments() : MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')
                    ->latest();
    }

    public function user() : HasOne {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    protected static function booted() : void 
    {
        static::created(function (Comment $comment) {
            Turn::create([
                'user_id' => $comment->user_id,
                'turnable_type' => $comment::class,
                'turnable_id' => $comment->id,
                'turn_type_id' => TurnType::support()->id,
            ]);
        });
    }
}
