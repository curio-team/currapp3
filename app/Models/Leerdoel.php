<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Leerdoel extends Model
{
    protected $table = 'leerdoelen';

    protected function naam(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->leerlijn->naam.'.'.str_pad($this->nummer, 2, 0, STR_PAD_LEFT)
        );
    }

    public function leerlijn(): BelongsTo
    {
        return $this->belongsTo(Leerlijn::class);
    }

    public function blokken(): MorphToMany
    {
        return $this->morphedByMany(Uitvoer::class, 'leerdoelable')->using(Leerdoelable::class)->withPivot('id');
    }

    public function modules(): MorphToMany
    {
        return $this->morphedByMany(Module::class, 'leerdoelable')->using(Leerdoelable::class)->withPivot('id');
    }
}
