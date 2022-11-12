<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acceptatiecriterium extends Model
{
    use HasFactory;

    protected $table = 'acceptatiecriteria';

    protected $casts = [
        'datum_start' => 'date',
        'datum_eind' => 'date',
    ];

    public function opleiding()
    {
        return $this->belongsTo(Opleiding::class);
    }

    public function modules()
    {
        return $this->belongsToMany(ModuleVersie::class, 'acceptatiecriterium_module')->withPivot(['voldoet', 'opmerking']);
    }
}
