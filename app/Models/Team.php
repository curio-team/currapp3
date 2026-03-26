<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Table('teams')]
class Team extends Model
{
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->orderBy('naam');
    }

    public function opleidingen(): HasMany
    {
        return $this->hasMany(Opleiding::class);
    }
}
