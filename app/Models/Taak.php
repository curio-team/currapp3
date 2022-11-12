<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taak extends Model
{
    protected $table = 'taken';

    public function opleiding()
    {
        return $this->belongsTo(Opleiding::class);
    }

    public function comments()
    {
        return $this->belongsToMany(Comment::class, 'comment_taak');
    }
}
