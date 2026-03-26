<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Table('modules')]
class Module extends Model
{
    public function eigenaarId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->leerlijn?->eigenaar_id,
        );
    }

    public function leerlijn(): BelongsTo
    {
        return $this->belongsTo(Leerlijn::class);
    }

    public function versies(): HasMany
    {
        return $this->hasMany(ModuleVersie::class);
    }
}
