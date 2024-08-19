<?php

namespace App\Models;

use App\Models\TurnType;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



class Turn extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    
    public function turnType(): BelongsTo
    {
        return $this->belongsTo(TurnType::class);
    }

    public function getValue() 
    {
        return $this->turnType->value;
    }
}
