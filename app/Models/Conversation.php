<?php

namespace App\Models;

use App\Models\Comment;
use App\Models\Community;
use App\Models\Contribution;
use App\Models\Turn;
use App\Models\TurnType;
use App\Turnable;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conversation extends Pivot
{
    use HasFactory, SoftDeletes, HasUuids, Turnable;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'conversations';

    public function community() : HasOne 
    {
        return $this->hasOne(Community::class, 'id', 'community_id');
    }

    public function contribution(): HasOne
    {
        return $this->hasOne(Contribution::class, 'id', 'contribution_id');
    }

    public function comments() : MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')
                    ->latest();
    }
    protected static function booted() : void 
    {
        static::created(function (Conversation $conversation) {
            Turn::create([
                'user_id' => $conversation->contribution->user_id,
                'turnable_type' => $conversation::class,
                'turnable_id' => $conversation->id,
                'turn_type_id' => TurnType::support()->id,
            ]);
        });
    }
}
