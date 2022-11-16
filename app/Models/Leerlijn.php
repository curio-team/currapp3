<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leerlijn extends Model
{
    use HasFactory;

    protected $table = 'leerlijnen';

    public function opleiding()
    {
        return $this->belongsTo(Opleiding::class);
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function leerdoelen()
    {
        return $this->hasMany(Leerdoel::class);
    }

    public function acceptatiecriteria()
    {
        return $this->belongsToMany(Acceptatiecriterium::class, 'acceptatiecriterium_leerlijn');
    }
}
