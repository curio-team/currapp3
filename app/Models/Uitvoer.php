<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
            get: function ($value) {
                $month = $this->datum_start->format('n');
                $month = ($month >= 6) ? 'sep' : 'feb';
                return "{$this->blok->naam} ({$this->datum_start->format('y')}-{$month})";
            },
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
        return $this->hasMany(VakInUitvoer::class);
    }
}
