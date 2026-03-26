<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class Taak extends Model
{
    protected $table = 'taken';

    public function opleiding(): BelongsTo
    {
        return $this->belongsTo(Opleiding::class);
    }

    public function comments(): BelongsToMany
    {
        return $this->belongsToMany(Comment::class, 'comment_taak');
    }
}
