<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphPivot;

class Leerdoelable extends MorphPivot
{
    public $incrementing = true;
    protected $table = 'leerdoelables';

    public function aspecten()
    {
        return $this->hasMany(Aspect::class, 'leerdoelable_id', 'id');
    }
}
