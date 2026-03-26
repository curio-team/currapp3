<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'teams';

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->orderBy('naam');
    }

    public function opleidingen(): HasMany
    {
        return $this->hasMany(Opleiding::class);
    }
}
