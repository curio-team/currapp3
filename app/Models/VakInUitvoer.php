<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
            ->withTimestamps()
            ->orderBy('week_start');
    }

    private function getColsArray()
    {
        $weeks = array();
        for($i = 1; $i <= optional($this->uitvoer)->weeks; $i++) $weeks[$i] = 0;
        
        $cols = array();
        foreach($this->modules as $module)
        {
            //Pak het stukje uit $weeks wat voor deze module geldig is
            $parts = array_slice($weeks, $module->pivot->week_start-1, ($module->pivot->week_eind-$module->pivot->week_start)+1, true);
            //var_dump([$module->id => $parts, "------------"]);

            // ...voeg dan toe aan kolom 0
            $cols[max($parts)][] = $module->id;
            
            // ...en zet dan de teller op weeks op 1:
            for($i = $module->pivot->week_start; $i <= $module->pivot->week_eind; $i++)
            {
                $weeks[$i] += 1;
            }
        }
        return $cols;
    }

    public function aantalKolommen() : Attribute
    {
        return Attribute::make(
            get: fn () => count($this->getColsArray()),
        );    
    }

    public function kolomIndeling() : Attribute
    {
        $modules = array();
        foreach($this->getColsArray() as $key => $col)
        {
            foreach($col as $module_id)
            {
                $modules[$module_id] = $key;
            }
        }

        return Attribute::make(
            get: fn () => $modules,
        );    
    }
}
