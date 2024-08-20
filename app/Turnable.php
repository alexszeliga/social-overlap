<?php

namespace App;

trait Turnable
{
    public function getScore() {
        return $this->turns->map(fn($t)=>$t->getValue())->sum();
    }
}
