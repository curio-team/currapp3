<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    public $incrementing = false;

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function naam(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes['name'],
        );
    }

    public function opleidingen(): HasMany
    {
        return $this->hasMany(Opleiding::class, 'eigenaar_id');
    }

    public function leerlijnen(): HasMany
    {
        return $this->hasMany(Leerlijn::class, 'eigenaar_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'eigenaar_id');
    }

    public function taken(): HasMany
    {
        return $this->hasMany(Taak::class, 'eigenaar_id');
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class)->orderBy('naam');
    }

    public function opleiding(): BelongsTo
    {
        return $this->belongsTo(Opleiding::class, 'standaard_opleiding');
    }
}
