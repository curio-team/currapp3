<?php

namespace App\Http\Livewire;

use App\Models\Opleiding;
use App\Models\Uitvoer;
use App\Models\ModuleVersie;
use App\Models\Vak;
use App\Models\VakInUitvoer;

class Leerplan extends _MyComponent
{
    public Opleiding $opleiding;
    public Uitvoer $uitvoer;
    public $versie_id;
    public $uitvoeren = [];

    protected $className = \App\Models\ModuleVersie::class;
    protected $rules = [
        'versie_id' => 'required',
        'item.pivot.week_start' => 'required',
        'item.pivot.week_eind' => 'required',
        'item.pivot.vak_in_uitvoer_id' => 'required',
    ];

    public function mount()
    {
        parent::mount();
        $this->uitvoeren[0] = $this->uitvoer->id;
        foreach(\App\Models\Uitvoer::where('blok_id', $this->uitvoer->blok_id)->whereDate('datum_start', '>', date('Y-m-d'))->where('id', '<>', $this->uitvoer->id)->orderBy('datum_start')->get() as $u)
        {
            $this->uitvoeren[] = $u->id;
        }
    }

    public function render()
    {
        return view('uitvoeren.leerplan');
    }

    public function setVersieItem($module_id, $vak_id)
    {
        $vak = VakInUitvoer::find($vak_id);
        $this->item = $vak->modules()->find($module_id);
        $this->versie_id = $this->item->id;
    }

    public function editModule()
    {
        if($this->versie_id == $this->item->id)
        {
            $this->item->vakken()->updateExistingPivot($this->item->pivot['vak_in_uitvoer_id'], [
                'week_start' => $this->item->pivot['week_start'],
                'week_eind' => $this->item->pivot['week_eind'],
            ]);
    
        }
        else
        {
            $vak = VakInUitvoer::find($this->item->pivot['vak_in_uitvoer_id']);
            $vak->modules()->detach($this->item->id);
            $vak->modules()->attach($this->versie_id, [
                'week_start' => $this->item->pivot['week_start'],
                'week_eind' => $this->item->pivot['week_eind'],
            ]);
        }

        $this->endModal();
    }

    public function unlinkModulePreview()
    {
        $this->emit('confirm');
        $this->emit('unlinkModulePreview');
    }

    public function unlinkModule()
    {
        $vak_id = VakInUitvoer::find($this->item->pivot['vak_in_uitvoer_id'])->vak_id;
        foreach($this->uitvoeren as $uitvoer_id)
        {
            if($uitvoer_id)
            {
                $vak = VakInUitvoer::where('vak_id', $vak_id)->where('uitvoer_id', $uitvoer_id)->first();
                $vak->modules()->detach($this->item->id);
            }
        }
        $this->endModal();
    }
}
