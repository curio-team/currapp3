<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blok extends Model
{
    use HasFactory;

    protected $table = 'blokken';

    public function eigenaar()
    {
        if($this->belongsTo(User::class, 'eigenaar_id')->exists())
        {
            return $this->belongsTo(User::class, 'eigenaar_id');
        }
        
        // Als dit blok geen eigenaar heeft, default dan naar eigenaar van de opleiding;
        return $this->opleiding->eigenaar();
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
