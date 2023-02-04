<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opleiding extends Model
{
    protected $table = 'opleidingen';

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function eigenaar()
    {
        return $this->belongsTo(User::class, 'eigenaar_id');
    }

    public function cohorten()
    {
        return $this->hasMany(Cohort::class)->orderBy('datum_start');
    }

    public function vakken()
    {
        return $this->hasMany(Vak::class)->orderBy('volgorde');
    }

    public function blokken()
    {
        return $this->hasMany(Blok::class)->orderBy('volgorde');
    }

    public function leerlijnen()
    {
        return $this->hasMany(Leerlijn::class);
    }

    public function acceptatiecriteria()
    {
        return $this->hasMany(Acceptatiecriterium::class);
    }

    public function modules()
    {
        return $this->hasManyThrough(Module::class, Leerlijn::class);
    }

    public function taken()
    {
        return $this->hasMany(Taak::class);
    }
}
