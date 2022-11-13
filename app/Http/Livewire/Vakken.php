<?php

namespace App\Http\Livewire;

use App\Models\Opleiding;
use App\Models\Vak;
use Livewire\Component;

class Vakken extends Component
{
    public Opleiding $opleiding;
    public $vak;

    protected $rules = [
        'vak.naam' => 'required',
        'vak.omschrijving' => 'nullable',
        'vak.volgorde' => 'required|integer|min:0',
    ];

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount()
    {
        $this->vak = new Vak();
    }

    public function render()
    {
        return view('vakken.index')
            ->extends('layouts.app', ['opleiding' => $this->opleiding])
            ->section('main');
    }

    public function create()
    {
        $this->validate($this->rules);
        $this->vak->opleiding_id = $this->opleiding->id;
        $this->vak->save();
        $this->endModal();
    }

    public function update()
    {
        $this->validate($this->rules);
        $this->vak->save();
        $this->endModal();
    }

    public function destroy()
    {
        foreach($this->vak->uitvoeren as $uitvoer)
        {
            $uitvoer->modules()->detach();
            $uitvoer->delete();
        }
        $this->vak->delete();
        $this->endModal();
    }

    public function setVak($id)
    {
        $this->vak = Vak::find($id);
    }

    public function clearVak()
    {
        $this->vak = new Vak();
    }

    private function endModal()
    {
        $this->clearVak();
        $this->emit('confirm');
        $this->emit('refreshComponent');
    }
}
