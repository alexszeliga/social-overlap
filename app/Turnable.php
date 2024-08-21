<?php

namespace App;

use App\Models\User;
use App\Models\Turn;

use Illuminate\Database\Eloquent\Relations\MorphMany;


trait Turnable
{
    public function getScore() {
        return $this->turns->map(fn($t)=>$t->getValue())->sum();
    }

    public function userHasTurned(User $user) {
        return $this->turns->pluck('user_id')->contains($user->id);
    }

    public function turns() : MorphMany
    {
        return $this->morphMany(Turn::class, 'turnable');
    }
}
