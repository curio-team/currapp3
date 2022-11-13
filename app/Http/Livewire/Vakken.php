<?php

namespace App\Http\Livewire;
use App\Models\Opleiding;

class Vakken extends MyComponent
{
    public Opleiding $opleiding;

    protected $className = \App\Models\Vak::class;
    protected $rules = [
        'item.naam' => 'required',
        'item.omschrijving' => 'nullable',
        'item.volgorde' => 'required|integer|min:0',
    ];

    public function render()
    {
        return view('vakken.index')
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

    public function destroy()
    {
        foreach($this->item->uitvoeren as $uitvoer)
        {
            $uitvoer->modules()->detach();
            $uitvoer->delete();
        }
        $this->item->delete();
        $this->endModal();
    }
}
