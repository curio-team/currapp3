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
        'item.omschrijving' => 'required',
        'item.map_url' => 'nullable',
        'item.leerlijn_id' => 'nullable',
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
        $this->item->save();

        $this->item->versies()->create(['versie' => 1]);
        $this->endModal();
    }

    public function update()
    {
        $this->validate($this->rules);
        $this->item->save();
        $this->endModal();
    }

    public function destroy()
    {
        $this->item->delete();
        $this->endModal();
    }
}
