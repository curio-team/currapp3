<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use \App\Models\Opleiding;
use \App\Models\Module;

class Leerlijn extends Model
{
    use HasFactory;

    protected $table = 'leerlijnen';

    public function opleiding()
    {
        return $this->belongsTo(Opleiding::class);
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }
}
