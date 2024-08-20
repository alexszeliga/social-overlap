<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TurnType extends Model
{
    public $timestamps = false;

    const SUPPORT = 1;
    const DISSENT = 2;
}
