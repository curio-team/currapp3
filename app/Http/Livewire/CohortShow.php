<?php

namespace App\Http\Livewire;

use App\Models\Blok;
use App\Models\Cohort;
use App\Models\Opleiding;
use App\Models\Uitvoer;

class CohortShow extends _MyComponent
{
    public Opleiding $opleiding;
    public Cohort $cohort;

    protected $className = \App\Models\Uitvoer::class;
    protected $rules = [
        'item.blok_id' => 'required',
        'item.schooljaar' => 'required|integer|min:0',
        'item.blok_in_schooljaar' => 'required|integer|min:0',
        'item.points' => 'required|integer|min:0',
    ];

    public function render()
    {
        return view('cohorten.show')
            ->extends('layouts.app', ['opleiding' => $this->opleiding])
            ->with('blokken', $this->opleiding->blokken)
            ->section('main');
    }

    public function link()
    {
        $this->validate($this->rules);

        $gevonden_uitvoer = Uitvoer::where('blok_id', $this->item->blok_id)
                                    ->where('schooljaar', $this->item->schooljaar)
                                    ->where('blok_in_schooljaar', $this->item->blok_in_schooljaar)
                                    ->first();

        if($gevonden_uitvoer != null)
        {
            $this->cohort->uitvoeren()->attach($gevonden_uitvoer);
        }
        else
        {
            $maanden_per_blok = 11 / $this->opleiding->blokken_per_jaar;
            $start_schooljaar = new \Carbon\CarbonImmutable("{$this->item->schooljaar}-09-01");
            
            $monthsToAdd = $maanden_per_blok * ($this->item->blok_in_schooljaar-1);
            $daysToAdd = 28 * ($monthsToAdd - floor($monthsToAdd));
            $this->item->datum_start = $start_schooljaar->addMonths($monthsToAdd)->addDays($daysToAdd);

            $monthsToAdd = $maanden_per_blok * ($this->item->blok_in_schooljaar);
            $daysToAdd = 28 * ($monthsToAdd - floor($monthsToAdd));
            $this->item->datum_eind = $start_schooljaar->addMonths($monthsToAdd)->addDays($daysToAdd-1);

            $this->cohort->uitvoeren()->save($this->item);
        }

        $this->endModal();
    }

    public function unlink()
    {
        $this->cohort->uitvoeren()->detach($this->item->id);
        $this->endModal();
    }

    public function destroy()
    {
        foreach($this->item->vakken as $vak)
        {
            $vak->modules()->detach();
            $vak->delete();
        }

        foreach($this->item->leerdoelen as $leerdoel)
        {
            foreach($leerdoel->pivot->aspecten as $aspect)
            {
                $aspect->delete();
            }
        }

        $this->item->leerdoelen()->detach();

        foreach($this->item->comments as $comment)
        {
            $comment->delete();
        }

        $this->item->cohorten()->detach();
        $this->item->delete();
        $this->endModal();
    }
}
