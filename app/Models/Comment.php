<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function taken(): BelongsToMany
    {
        return $this->belongsToMany(Taak::class, 'comment_taak');
    }
}
