<?php

namespace App\Http\Livewire;
use App\Models\Opleiding;

class Cohorten extends _MyComponent
{
    public Opleiding $opleiding;

    protected $className = \App\Models\Cohort::class;

    protected $rules = [
        'item.naam' => 'required',
        'item.datum_start' => 'required',
        'item.datum_eind' => 'required',
    ];

    public function render()
    {
        return view('cohorten.index')
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
            foreach($uitvoer->vakken as $vak)
            {
                $vak->modules()->detach();
                $vak->delete();
            }

            foreach($uitvoer->leerdoelen as $leerdoel)
            {
                foreach($leerdoel->pivot->aspecten as $aspect)
                {
                    $aspect->delete();
                }
            }

            $uitvoer->leerdoelen()->detach();

            foreach($uitvoer->comments as $comment)
            {
                $comment->delete();
            }

            $uitvoer->cohorten()->detach();
            $uitvoer->delete();
        }

        $this->item->delete();
        $this->endModal();
    }
}
