<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;

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

    public function opleidingen()
    {
        return $this->hasMany(Opleiding::class, 'eigenaar_id');
    }

    public function modules()
    {
        return $this->hasMany(Module::class, 'eigenaar_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'eigenaar_id');
    }

    public function taken()
    {
        return $this->hasMany(Taak::class, 'eigenaar_id');
    }

    public function teams()
	{
		return $this->belongsToMany(Team::class)->orderBy('name');
	}
}
