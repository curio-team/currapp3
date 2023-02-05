<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Cohort extends Model
{
    protected $table = 'cohorten';
    
    public function opleiding()
    {
        return $this->belongsTo(Opleiding::class);
    }

    public function uitvoeren()
    {
        return $this->belongsToMany(Uitvoer::class)->orderBy('datum_start');
    }
}
