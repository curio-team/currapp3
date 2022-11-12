<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Cohort;
use App\Models\Blok;
use App\Models\Leerlijn;
use App\Models\Acceptatiecriterium;
use App\Models\Module;

class Opleiding extends Model
{
    protected $table = 'opleidingen';

    public function eigenaar()
    {
        return $this->belongsTo(User::class, 'eigenaar_id');
    }

    public function cohorten()
    {
        return $this->hasMany(Cohort::class);
    }

    public function blokken()
    {
        return $this->hasMany(Blok::class);
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
}
