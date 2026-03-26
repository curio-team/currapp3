<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

#[Table('opleidingen')]
class Opleiding extends Model
{
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function cohorten(): HasMany
    {
        return $this->hasMany(Cohort::class)->orderBy('datum_start');
    }

    public function vakken(): HasMany
    {
        return $this->hasMany(Vak::class)->orderBy('volgorde');
    }

    public function blokken(): HasMany
    {
        return $this->hasMany(Blok::class)->orderBy('volgorde');
    }

    public function leerlijnen(): HasMany
    {
        return $this->hasMany(Leerlijn::class)->orderBy('naam');
    }

    public function acceptatiecriteria(): HasMany
    {
        return $this->hasMany(Acceptatiecriterium::class);
    }

    public function modules(): HasManyThrough
    {
        return $this->hasManyThrough(Module::class, Leerlijn::class)->orderBy('naam');
    }

    public function taken(): HasMany
    {
        return $this->hasMany(Taak::class);
    }

    public function uitvoeren(): HasManyThrough
    {
        return $this->hasManyThrough(Uitvoer::class, Blok::class);
    }
}
