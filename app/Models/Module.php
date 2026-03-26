<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'modules';

    public function eigenaarId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->leerlijn?->eigenaar_id,
        );
    }

    public function leerlijn()
    {
        return $this->belongsTo(Leerlijn::class);
    }

    public function versies()
    {
        return $this->hasMany(ModuleVersie::class);
    }
}
