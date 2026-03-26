<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vak extends Model
{
    use HasFactory;

    protected $table = 'vakken';

    public function opleiding(): BelongsTo
    {
        return $this->belongsTo(Opleiding::class);
    }

    public function uitvoeren(): HasMany
    {
        return $this->hasMany(VakInUitvoer::class);
    }
}
