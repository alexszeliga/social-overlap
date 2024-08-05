<?php

namespace App\Models;

use App\Models\Community;
use App\Models\CommunityUser;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;


class User extends Authenticatable
{
    use HasFactory, Notifiable;
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

    public static function boot() {
        parent::boot();
    
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    public function communities( ): BelongsToMany {
        return $this->belongsToMany(Community::class)
                    ->using(CommunityUser::class)
                    ->withTimestamps();
    }
}
