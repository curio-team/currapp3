<?php

namespace App\Http\Livewire;
use App\Models\Opleiding;
use App\Models\Cohort;
use App\Models\ModuleVersie;
use App\Models\Uitvoer;
use App\Models\VakInUitvoer;

class Modules extends _MyComponent
{
    public Opleiding $opleiding;

    protected $className = \App\Models\Module::class;
    protected $rules = [
        'item.naam' => 'required',
        'item.omschrijving' => 'nullable',
        'item.map_url' => 'nullable',
        'item.leerlijn_id' => 'nullable',
        'item.versie' => 'required'
    ];

    public function render()
    {
        return view('modules.index')
            ->extends('layouts.app', ['opleiding' => $this->opleiding])
            ->section('main');
    }

    public function create()
    {
        $this->validate($this->rules);
        $versie = $this->item->versie;
        unset($this->item->versie);
        $this->item->save();

        $this->item->versies()->create(['versie' => $versie]);
        $this->endModal();
    }

    public function update()
    {
        $this->validate($this->rules);
        unset($this->item->versie);
        $this->item->save();
        $this->endModal();
    }

    public function destroy()
    {
        $this->item->delete();
        $this->endModal();
    }
}
