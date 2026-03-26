<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Table('cohorten')]
class Cohort extends Model
{
    public function opleiding(): BelongsTo
    {
        return $this->belongsTo(Opleiding::class);
    }

    public function uitvoeren(): BelongsToMany
    {
        return $this->belongsToMany(Uitvoer::class)->orderBy('datum_start');
    }
}
