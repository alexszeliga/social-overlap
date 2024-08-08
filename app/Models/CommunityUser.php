<?php

namespace App\Models;

use App\Models\User;
use App\Models\Community;
use App\Models\Contribution;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class CommunityUser extends Pivot
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    public static function boot() {
        parent::boot();
    
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }
    public function user() : HasOne {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function community() : HasOne {
        return $this->hasOne(Community::class, 'id', 'community_id');
    }

    public function createContributionWithUrl($url) : ?Contribution {
        return Contribution::create([
            'user_id' => $this->user->id,
            'community_id' => $this->community->id,
            'url' => $url,
        ]);
    }
}
