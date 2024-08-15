<?php

namespace App\Models;

use App\Models\User;
use App\Models\CommunityContribution;
use App\Models\Contribution;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Community extends Model
{
    use HasFactory, HasUuids;
    
    protected $fillable = [
        'name','description',
    ];

    public static function rules() : array {
        return [
            'name' => ['required', 'string', 'max:60', 'regex:/^(?!.*[&$,:;=@#<>|%\+\?\[\]\{\}\[\]\\\^]).*$/'],
            'description' => ['required','string'],
            'slug' => ['required', 'unique:communities,slug'],
        ];
    }
    
    public static function boot() {
        parent::boot();
    
        static::creating(function ($model) {
            $model->slug = Str::slug($model->name);
        });
    }

    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class)
                    ->using(CommunityUser::class)
                    ->wherePivotNull('deleted_at')
                    ->withTimestamps();
    }

    public function contributions() : BelongsToMany {
        return $this->belongsToMany(Contribution::class)
                    ->using(CommunityContribution::class)
                    ->withTimestamps();
    }

    public function conversations() : HasMany {
        return $this->hasMany(CommunityContribution::class, 'community_id', 'id');
    }

    public function getId():string {
        return $this->id;
    }

    public function userIsSubscribed(User $user) {
        return $this->users->pluck('id')->contains($user->id);
    }
}
