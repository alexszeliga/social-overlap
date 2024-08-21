<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TurnType extends Model
{
    public $timestamps = false;

    const SUPPORT = 1;
    const DISSENT = 2;

    public static function support(): TurnType {
        return self::find(self::SUPPORT);
    }

    public static function dissent(): TurnType {
        return self::find(self::DISSENT);
    }
}
