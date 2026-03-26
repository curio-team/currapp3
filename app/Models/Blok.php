<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blok extends Model
{
    use HasFactory;

    protected $table = 'blokken';

    public function eigenaarId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ?? $this->opleiding?->eigenaar_id,
        );
    }

    public function opleiding()
    {
        return $this->belongsTo(Opleiding::class);
    }

    public function uitvoeren()
    {
        return $this->hasMany(Uitvoer::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
