<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[Table('blokken')]
class Blok extends Model
{
    use HasFactory;

    public function eigenaarId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ?? $this->opleiding?->eigenaar_id,
        );
    }

    public function opleiding(): BelongsTo
    {
        return $this->belongsTo(Opleiding::class);
    }

    public function uitvoeren(): HasMany
    {
        return $this->hasMany(Uitvoer::class);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
