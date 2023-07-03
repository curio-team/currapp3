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
                $month = optional($this->datum_start)->format('n');
                $month = ($month >= 6) ? 'sep' : 'feb';
                return optional($this->blok)->naam . " (" . optional($this->datum_start)->format('y') . "-" . $month . ")";
            },
        );
    }

    public function cohorten()
    {
        return $this->belongsToMany(Cohort::class)->orderBy('datum_start');
    }

    public function blok()
    {
        return $this->belongsTo(Blok::class);
    }

    public function vakken()
    {
        return $this->hasMany(VakInUitvoer::class)
                ->join('vakken', 'vakken.id', '=', 'vakken_in_uitvoer.vak_id')
                ->select('vakken_in_uitvoer.*')
                ->orderBy('vakken.volgorde');
    }

    public function leerdoelen()
    {
        return $this->morphToMany(Leerdoel::class, 'leerdoelable')->using(Leerdoelable::class)->withPivot('id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function studiepuntenOke() : Attribute
    {
        $result = true;

        // Als de minimumwaarde hiervan '1' is, dan is dan zijn dus alle vakken oke;
        if($this->vakken->min('studiepunten_oke') == 0) $result = false;
        if($this->points != $this->vakken->sum('points')) $result = false;

        return Attribute::make(
            get: fn () => $result,
        );    
    }
}
