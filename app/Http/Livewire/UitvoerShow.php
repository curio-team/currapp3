<?php

namespace App\Http\Livewire;
use App\Models\Opleiding;
use App\Models\Uitvoer;

class UitvoerShow extends _MyComponent
{
    public Opleiding $opleiding;
    public Uitvoer $uitvoer;

    protected $className = \App\Models\VakInUitvoer::class;
    protected $rules = [
        'item.naam' => 'required',
        'item.datum_start' => 'required',
        'item.datum_eind' => 'required',
    ];

    public function render()
    {
        return view('uitvoeren.show')
            ->extends('layouts.app', ['opleiding' => $this->opleiding])
            ->section('main');
    }

    public function create()
    {
        $this->validate($this->rules);
        $this->item->opleiding_id = $this->opleiding->id;
        $this->item->save();
        $this->endModal();
    }

    public function update()
    {
        $this->validate($this->rules);
        $this->item->save();
        $this->endModal();
    }
}
