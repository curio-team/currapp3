<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Table('comments')]
class Comment extends Model
{
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function taken(): BelongsToMany
    {
        return $this->belongsToMany(Taak::class, 'comment_taak');
    }
}
