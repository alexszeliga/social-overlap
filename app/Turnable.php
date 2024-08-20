<?php

namespace App;

use App\Models\User;

trait Turnable
{
    public function getScore() {
        return $this->turns->map(fn($t)=>$t->getValue())->sum();
    }

    public function userHasTurned(User $user) {
        return $this->turns->pluck('user_id')->contains($user->id);
    }
}
