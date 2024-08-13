<?php

namespace App\Models;

use App\Models\User;
use App\Models\Community;
use App\Models\CommunityContribution;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contribution extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = ['user_id','url'];

    public function user() : HasOne {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function communities() : BelongsToMany {
        return $this->belongsToMany(Community::class)
                    ->using(CommunityContribution::class)
                    ->withTimestamps();
    }

    public function addCommunity(Community $community) {
        $this->communities()->attach($community);
    }
}
