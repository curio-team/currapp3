<?php

namespace App\Http\Livewire;
use App\Models\Opleiding;

class Leerlijnen extends _MyComponent
{
    public Opleiding $opleiding;

    protected $className = \App\Models\Leerlijn::class;
    protected $rules = [
        'item.naam' => 'required',
        'item.color' => 'required',
    ];

    public function render()
    {
        return view('leerlijnen.index')
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
        $this->item->delete();
        $this->endModal();
    }
}
