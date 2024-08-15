<?php

namespace App\Models;

use App\Models\Comment;
use App\Models\Community;
use App\Models\Contribution;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommunityContribution extends Pivot
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

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
        return $this->morphMany(Comment::class, 'commentable');
    }  
}
