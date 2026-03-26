<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class ModuleVersie extends Model
{
    protected $fillable = ['versie'];

    protected $table = 'module_versies';

    protected function naam(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => "v{$this->versie}.X",
        );
    }

    protected function points(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->feedbackmomenten->sum('points'),
        );
    }

    protected function aantalFeedbackmomenten(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->feedbackmomenten->count(),
        );
    }

    protected function maxPunten(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->feedbackmomenten->max('points'),
        );
    }

    protected function aantalChecksNietOke(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->feedbackmomenten()->whereNull('checks')->count(),
        );
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

    public function vakken(): BelongsToMany
    {
        return $this->belongsToMany(VakInUitvoer::class, 'module_vak')->withPivot(['week_start', 'week_eind'])->withTimestamps();
    }

    public function leerdoelen(): MorphToMany
    {
        return $this->morphToMany(Leerdoel::class, 'leerdoelable')->using(Leerdoelable::class)->withPivot('id');
    }

    public function acceptatiecriteria(): BelongsToMany
    {
        return $this->belongsToMany(Acceptatiecriterium::class, 'acceptatiecriterium_module')->withPivot(['voldoet', 'opmerking', 'reviewer_id']);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function feedbackmomenten(): BelongsToMany
    {
        return $this->belongsToMany(Feedbackmoment::class)->withPivot(['week']);
    }
}
