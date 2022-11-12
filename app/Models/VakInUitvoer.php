<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Vak;
use App\Models\Uitvoer;
use App\Models\ModuleVersie;

class VakInUitvoer extends Model
{
    protected $table = 'vakken_in_uitvoer';

    public function parent()
    {
        return $this->belongsTo(Vak::class, 'vak_id');
    }

    public function uitvoer()
    {
        return $this->belongsTo(Uitvoer::class);
    }

    public function modules()
    {
        return $this->belongsToMany(ModuleVersie::class, 'module_vak')
            ->withPivot(['week_start', 'week_eind'])
            ->withTimestamps();
    }
}
