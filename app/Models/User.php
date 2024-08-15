<?php

namespace App\Models;

use App\Models\Community;
use App\Models\CommunityUser;
use App\Models\Contribution;
use App\Models\CommunityContribution;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids;
    
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function communities( ): BelongsToMany {
        return $this->belongsToMany(Community::class)
                    ->using(CommunityUser::class)
                    ->wherePivotNull('deleted_at')
                    ->withTimestamps();
    }

    public function claimCommunity(Community $community) : void {
        $this->communities()->attach($community);
    }

    public function disownCommunity(Community $community) : void {
        $this->communities()->detach($community);
    }

    public function homepageQuery() 
    {
        return CommunityContribution::whereHas('community.users', function ($query) {
            $query->where('users.id', '=', $this->id);
        });
    }

}
