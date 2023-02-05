<?php

namespace App\Http\Livewire;
use App\Models\Opleiding;
use App\Models\Cohort;
use App\Models\Uitvoer;

class Cohorten extends _MyComponent
{
    public Opleiding $opleiding;

    protected $className = \App\Models\Cohort::class;
    protected $rules = [
        'item.naam' => 'required',
        'item.datum_start' => 'required',
        'item.datum_eind' => 'required',
    ];

    public $kopieer_van;
    public $kopieer_jaren;
    protected $copyrules = [
        'item.naam' => 'required',
        'kopieer_van' => 'required',
        'kopieer_jaren' => 'required',
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

    public function copy()
    {
        $this->validate($this->copyrules);
        $cohort_oud = Cohort::find($this->kopieer_van);

        $this->item->datum_start = \Carbon\CarbonImmutable::createFromFormat("Y-m-d", $cohort_oud->datum_start)->addYears($this->kopieer_jaren);
        $this->item->datum_eind  = \Carbon\CarbonImmutable::createFromFormat("Y-m-d", $cohort_oud->datum_eind )->addYears($this->kopieer_jaren);
        $this->opleiding->cohorten()->save($this->item);

        foreach($cohort_oud->uitvoeren as $uitvoer_oud)
        {
            $schooljaar_nieuw = $uitvoer_oud->schooljaar + $this->kopieer_jaren;

            $gevonden_uitvoer = Uitvoer::where('blok_id', $uitvoer_oud->blok_id)
                                    ->where('schooljaar', $schooljaar_nieuw)
                                    ->where('blok_in_schooljaar', $uitvoer_oud->blok_in_schooljaar)
                                    ->first();

            if($gevonden_uitvoer != null)
            {
                $this->item->uitvoeren()->attach($gevonden_uitvoer);
            }
            else
            {
                $uitvoer_nieuw = new Uitvoer();
                $uitvoer_nieuw->blok_id = $uitvoer_oud->blok_id;
                $uitvoer_nieuw->schooljaar = $schooljaar_nieuw;
                $uitvoer_nieuw->blok_in_schooljaar = $uitvoer_oud->blok_in_schooljaar;

                $maanden_per_blok = 11 / $this->opleiding->blokken_per_jaar;
                $start_schooljaar = new \Carbon\CarbonImmutable("{$schooljaar_nieuw}-09-01");
                
                $monthsToAdd = $maanden_per_blok * ($uitvoer_oud->blok_in_schooljaar-1);
                $daysToAdd = 28 * ($monthsToAdd - floor($monthsToAdd));
                $uitvoer_nieuw->datum_start = $start_schooljaar->addMonths($monthsToAdd)->addDays($daysToAdd);
    
                $monthsToAdd = $maanden_per_blok * ($uitvoer_oud->blok_in_schooljaar);
                $daysToAdd = 28 * ($monthsToAdd - floor($monthsToAdd));
                $uitvoer_nieuw->datum_eind = $start_schooljaar->addMonths($monthsToAdd)->addDays($daysToAdd-1);
    
                $this->item->uitvoeren()->save($uitvoer_nieuw);
            }
        }

        $this->endModal();
    }
}
