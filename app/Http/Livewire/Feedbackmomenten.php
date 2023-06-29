<?php

namespace App\Http\Livewire;

use App\Models\Feedbackmoment;
use App\Models\ModuleVersie;
use App\Models\Opleiding;

class Feedbackmomenten extends _MyComponent
{
    public $week;
    public ModuleVersie $versie;
    public Opleiding $opleiding;
    protected $className = \App\Models\Feedbackmoment::class;
    protected $rules = [
        'item.naam' => 'required',
        'item.checks' => 'nullable',
        'item.points' => 'required|integer|min:1',
        'item.cesuur' => 'required|integer|min:70|max:100',
        'week' => 'required|integer|min:1|max:16',
    ];

    public function render()
    {
        return view('feedbackmomenten.index');
    }

    public function setFbmItem(Feedbackmoment $item, $week)
    {
        $this->item = $item;
        $this->week = $week;
    }

    public function edit()
    {
        $this->validate($this->rules);
        if(empty($this->item->checks)) $this->item->checks = null;
        $this->item->save();
        $this->versie->feedbackmomenten()->updateExistingPivot(
            $this->item->id,
            ['week' => $this->week]
        );
        $this->endModal();
    }

    public function destroy()
    {
        $this->item->modules()->detach();
        $this->item->delete();
        $this->endModal();
    }
}
