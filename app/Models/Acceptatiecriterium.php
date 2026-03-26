<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Acceptatiecriterium extends Model
{
    use HasFactory;

    protected $table = 'acceptatiecriteria';

    protected $casts = [
        'datum_start' => 'date',
        'datum_eind' => 'date',
    ];

    public function opleiding(): BelongsTo
    {
        return $this->belongsTo(Opleiding::class);
    }

    public function modules(): BelongsToMany
    {
        return $this->belongsToMany(ModuleVersie::class, 'acceptatiecriterium_module')->withPivot(['voldoet', 'opmerking', 'reviewer_id']);
    }

    public function leerlijnen(): BelongsToMany
    {
        return $this->belongsToMany(Leerlijn::class, 'acceptatiecriterium_leerlijn');
    }
}
