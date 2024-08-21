<?php

namespace App;

use App\Models\User;
use App\Models\Turn;
use Illuminate\Support\ItemNotFoundException;

use Illuminate\Database\Eloquent\Relations\MorphMany;


trait Turnable
{
    public function getScore() {
        return $this->turns->map(fn($t)=>$t->getValue())->sum();
    }

    public function userHasTurned(User $user) {
        return $this->turns->pluck('user_id')->contains($user->id);
    }

    public function getUserSupportTypeName(User $user):string {
        try {
            return $this->turns->where('user_id', $user->id)->sole()->turnType->name;
        }
        catch (ItemNotFoundException $e) {
            return '';
        }
    }

    public function turns() : MorphMany
    {
        return $this->morphMany(Turn::class, 'turnable');
    }
}
