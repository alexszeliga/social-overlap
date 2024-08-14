<?php

namespace App\Models;

use App\Models\CommunityContribution;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    public function converstaion() : HasOne 
    {
        return $this->hasOne(CommunityContribution::class, 'id', 'community_contribution_id');
    }

    public function commentable() : MorphTo 
    {
        return $this->morphTo();
    }
}
