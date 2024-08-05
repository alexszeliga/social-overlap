<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Str;

class CommunityUser extends Pivot
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    public static function boot() {
        parent::boot();
    
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }
}
