<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    public function commentable()
    {
        return $this->morphTo();
    }

    public function taken()
    {
        return $this->belongsToMany(Taak::class, 'comment_taak');
    }
}
