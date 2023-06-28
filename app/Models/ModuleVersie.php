<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ModuleVersie extends Model
{
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

    public function parent()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

    public function vakken()
    {
        return $this->belongsToMany(VakInUitvoer::class, 'module_vak')->withPivot(['week_start', 'week_eind'])->withTimestamps();
    }
    
    public function leerdoelen()
    {
        return $this->morphToMany(Leerdoel::class, 'leerdoelable')->using(Leerdoelable::class)->withPivot('id');
    }

    public function acceptatiecriteria()
    {
        return $this->belongsToMany(Acceptatiecriterium::class, 'acceptatiecriterium_module')->withPivot(['voldoet', 'opmerking', 'reviewer_id']);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function feedbackmomenten()
    {
        return $this->belongsToMany(Feedbackmoment::class,)->withPivot(['week']);
    }
}
