<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'teams';

    public function users()
	{
		return $this->belongsToMany(User::class)->orderBy('naam');
	}

	public function opleidingen()
	{
		return $this->hasMany(Opleiding::class);
	}
}
