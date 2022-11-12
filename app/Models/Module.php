<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'modules';

    public function eigenaar()
    {
        if($this->belongsTo(User::class, 'eigenaar_id')->exists())
        {
            return $this->belongsTo(User::class, 'eigenaar_id');
        }
        
        // Als deze module geen eigenaar heeft, default dan naar eigenaar van de opleiding;
        return $this->opleiding->eigenaar();
    }

    public function opleiding()
    {
        return $this->hasOneThrough(Opleiding::class, Leerlijn::class);
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
