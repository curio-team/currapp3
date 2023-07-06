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

    public function points() : Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if($this->gelinkt_aan_vak_id)
                {
                    return VakInUitvoer::find($this->gelinkt_aan_vak_id)->points;
                }
                return $value;
            },
        );    
    }

    public function sumPoints() : Attribute
    {
        $sum = 0;
        $modules = $this->modules->unique('module_id');
        foreach($modules as $m)
        {
            $start = $m->pivot->week_start;
            $eind = $m->pivot->week_eind;

            $fbms = $m->feedbackmomenten()->whereBetween('week', [$start, $eind])->get();
            $sum += $fbms->sum('points');
        }

        return Attribute::make(
            get: fn () => $sum,
        );    
    }

    private function getColsArray()
    {
        $weeks = array();
        $cols = array();
        $modules_cols = array();
        for($i = 1; $i <= optional($this->uitvoer)->weeks; $i++) $weeks[$i] = 0;

        foreach($this->modules as $module)
        {
            $i = 0;
            do{
                if(!array_key_exists($i, $cols)) $cols[$i] = $weeks;
                $parts = array_slice($cols[$i], $module->pivot->week_start-1, ($module->pivot->week_eind-$module->pivot->week_start)+1, true);
                $i++;
            } while(max($parts) > 0);

            // ...en zet dan de teller op weeks op +1:
            for($j = $module->pivot->week_start; $j <= $module->pivot->week_eind; $j++)
            {
                if(array_key_exists($j, $weeks)) $cols[$i-1][$j] += 1; //= $module->id;
            }

            //En zet deze module in de juiste kolom;
            $modules_cols[$module->id] = $i-1;
        }
        return $modules_cols;
    }

    public function aantalKolommen() : Attribute
    {
        $value = 1;
        if(count($this->getColsArray())) $value = max($this->getColsArray())+1;
        return Attribute::make(
            get: fn () => $value,
        );    
    }

    public function kolomIndeling() : Attribute
    {
        return Attribute::make(
            get: fn () => $this->getColsArray(),
        );    
    }

    public function studiepuntenOke() : Attribute
    {
        $result = true;
        if($this->points != $this->sum_points) $result = false;
        if($this->modules->sum('aantal_feedbackmomenten') < 1) $result = false;
        if($this->modules->max('max_punten') > optional($this->uitvoer)->points*0.10) $result = false;
        if($this->modules->sum('aantal_checks_niet_oke') > 0) $result = false;
        if(!$this->bpoints) $result = false;

        return Attribute::make(
            get: fn () => $result,
        );    
    }
}
