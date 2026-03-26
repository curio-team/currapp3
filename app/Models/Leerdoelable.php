<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphPivot;

class Leerdoelable extends MorphPivot
{
    public $incrementing = true;

    protected $table = 'leerdoelables';

    public function aspecten(): HasMany
    {
        return $this->hasMany(Aspect::class, 'leerdoelable_id', 'id');
    }
}
