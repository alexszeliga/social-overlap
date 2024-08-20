<?php

namespace App\Models;

use App\Models\TurnType;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;



class Turn extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    public $fillable = [
        'user_id',
        'turnable_id',
        'turnable_type',
        'turn_type_id',        
    ];
    
    public function turnType(): BelongsTo
    {
        return $this->belongsTo(TurnType::class);
    }

    public function root(): HasOne
    {
        return $this->hasOne($this->turnable_type, 'id', 'turnable_id');
    }

    public function getValue() 
    {
        return $this->turnType->value;
    }
}
