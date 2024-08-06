<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function users( ): BelongsToMany {
        return $this->belongsToMany(Community::class)
                    ->using(CommunityUser::class)
                    ->withTimestamps();
    }

    public function getId():string {
        return $this->id;
    }
}
