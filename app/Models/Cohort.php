<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Cohort extends Model
{
    protected $table = 'cohorten';

    // protected $casts = [
    //     'datum_start' => 'datetime',
    //     'datum_eind' => 'datetime',
    // ];

    protected function naam(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => 'C' . substr($this->datum_start, 2, 2),
        );
    }

    public function opleiding()
    {
        return $this->belongsTo(Opleiding::class);
    }

    public function uitvoeren()
    {
        return $this->hasMany(Uitvoer::class);
    }
}
