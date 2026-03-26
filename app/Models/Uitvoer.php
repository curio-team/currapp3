<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

#[Table('uitvoeren')]
class Uitvoer extends Model
{
    protected function casts(): array
    {
        return [
            'datum_start' => 'date',
            'datum_eind' => 'date',
        ];
    }

    protected function naam(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $month = $this->datum_start?->format('n');
                $month = ($month >= 6) ? 'sep' : 'feb';

                return $this->blok?->naam.' ('.$this->datum_start?->format('y').'-'.$month.')';
            },
        );
    }

    public function cohorten(): BelongsToMany
    {
        return $this->belongsToMany(Cohort::class)->orderBy('datum_start');
    }

    public function blok(): BelongsTo
    {
        return $this->belongsTo(Blok::class);
    }

    public function vakken(): HasMany
    {
        return $this->hasMany(VakInUitvoer::class)
            ->join('vakken', 'vakken.id', '=', 'vakken_in_uitvoer.vak_id')
            ->select('vakken_in_uitvoer.*')
            ->orderBy('vakken.volgorde');
    }

    public function leerdoelen(): MorphToMany
    {
        return $this->morphToMany(Leerdoel::class, 'leerdoelable')->using(Leerdoelable::class)->withPivot('id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    protected function totaalPunten(): Attribute
    {
        $punten = $this->vakken()->whereNull('gelinkt_aan_vak_id')->sum('points');

        return Attribute::make(
            get: fn () => $punten,
        );
    }

    public function studiepuntenOke(): Attribute
    {
        $result = true;

        // Als de minimumwaarde hiervan '1' is, dan is dan zijn dus alle vakken oke;
        if ($this->vakken->min('studiepunten_oke') == 0) {
            $result = false;
        }
        if ($this->points != $this->totaal_punten) {
            $result = false;
        }

        return Attribute::make(
            get: fn () => $result,
        );
    }
}
