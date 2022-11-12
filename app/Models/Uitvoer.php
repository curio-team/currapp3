<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

use App\Models\Cohort;
use App\Models\Blok;
use App\Models\Vak;

class Uitvoer extends Model
{
    protected $table = 'uitvoeren';

    protected $casts = [
        'datum_start' => 'date',
        'datum_eind' => 'date',
    ];

    protected function naam(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => "{$this->blok->naam} ({$this->datum_start->format('y')}-{$this->datum_start->format('M')})",
        );
    }

    public function cohort()
    {
        return $this->belongsTo(Cohort::class);
    }

    public function blok()
    {
        return $this->belongsTo(Blok::class);
    }

    public function vakken()
    {
        return $this->hasMany(Vak::class);
    }
}
