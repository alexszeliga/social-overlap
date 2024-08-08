<?php

namespace App\Models;

use App\Models\User;
use App\Models\Community;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class CommunityUser extends Pivot
{
    use HasFactory, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    public static function boot() {
        parent::boot();
    
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }
    public function user() : HasOne {
        return $this->hasOne(User::class);
    }
    public function community() : HasOne {
        return $this->hasOne(Community::class);
    }
}
