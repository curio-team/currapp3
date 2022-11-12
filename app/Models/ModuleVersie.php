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
        return $this->belongsToMany(Acceptatiecriterium::class, 'acceptatiecriterium_module')->withPivot(['voldoet', 'opmerking']);
    }
}
