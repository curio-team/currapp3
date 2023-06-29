<?php

namespace App\Http\Controllers;

use App\Models\ModuleVersie;
use App\Models\Opleiding;
use App\Models\Uitvoer;
use App\Models\VakInUitvoer;
use Illuminate\Http\Request;

class UitvoerController extends Controller
{
    public function show(Opleiding $opleiding, Uitvoer $uitvoer)
    {
        return view('uitvoeren.show')
                ->with('opleiding', $opleiding)
                ->with('uitvoer', $uitvoer);
    }

    public function link_vak_preview(Uitvoer $uitvoer, Request $request)
    {
        // Koppel nieuw aangevinkte vakken:
        $added = [];
        foreach($request->vakken as $vak_id)
        {
            if($uitvoer->vakken->doesntContain('vak_id', $vak_id))
            {
                $added[] = $vak_id;
            }
        }

        // Verwijder uitgevinkte vakken:
        $removed = [];
        $vakken = collect($request->vakken);
        foreach($uitvoer->vakken as $vak)
        {
            if($vakken->doesntContain($vak->vak_id))
            {
                $removed[] = $vak->vak_id;
            }
        }

        if(count($added) || count($removed))
        {
            return redirect()->back()->with('vakken_update_preview', ['added' => $added, 'removed' => $removed]);
        }
        else
        {
            return redirect()->back();
        }
    }

    public function link_vak(Uitvoer $uitvoer, Request $request)
    {
        $removed = collect($request->removed);
        $added   = collect($request->added);

        foreach($request->uitvoeren as $uitvoer_id)
        {
            $uitvoer = Uitvoer::find($uitvoer_id);

            foreach($added as $vak_id)
            {
                if($uitvoer->vakken->doesntContain('vak_id', $vak_id))
                {
                    $vak = new VakInUitvoer();
                    $vak->vak_id = $vak_id;
                    $vak->uitvoer_id = $uitvoer_id;
                    $vak->save();
                }
            }

            foreach($uitvoer->vakken as $vak)
            {
                if($removed->contains($vak->vak_id))
                {
                    $vak->modules()->detach();
                    $vak->delete();
                }
            }
        }

        return redirect()->back();
    }

    public function link_module_preview(Uitvoer $uitvoer, Request $request)
    {
        return redirect()->back()->with('link_module_preview', [... $request->all()]);
    }

    public function link_module(Uitvoer $uitvoer, Request $request)
    {
        $vak_id = VakInUitvoer::find($request->vak_id)->parent->id;
        $module_versie = ModuleVersie::where('module_id', $request->module_id)->orderByDesc('versie')->first();

        foreach($request->uitvoeren as $uitvoer_id)
        {
            $vak = VakInUitvoer::where('vak_id', $vak_id)->where('uitvoer_id', $uitvoer_id)->first();
            if(!$vak)
            {
                $vak = new VakInUitvoer();
                $vak->vak_id = $vak_id;
                $vak->uitvoer_id = $uitvoer_id;
                $vak->save();
            }

            $vak->modules()->attach($module_versie, [
                'week_start' => $request->week_start,
                'week_eind' => $request->week_eind,
            ]);
        }

        return redirect()->back();
    }

    public function edit_points_preview(Uitvoer $uitvoer, Request $request)
    {
        return redirect()->back()->with('edit_points_preview', [... $request->all()]);
    }

    public function edit_points(Request $request)
    {
        foreach($request->uitvoeren as $uitvoer_id)
        {
            $uitvoer = Uitvoer::find($uitvoer_id);
            $uitvoer->points = $request->points;
            $uitvoer->save();
        }
        return redirect()->back();
    }

    public function edit_weeks_preview(Request $request)
    {
        return redirect()->back()->with('edit_weeks_preview', [... $request->all()]);
    }

    public function edit_weeks(Request $request)
    {
        foreach($request->uitvoeren as $uitvoer_id)
        {
            $uitvoer = Uitvoer::find($uitvoer_id);
            $uitvoer->weeks = $request->weeks;
            $uitvoer->save();
        }
        return redirect()->back();
    }

    public function studiepuntenplan_vak(VakInUitvoer $vak)
    {
        return view('uitvoeren.studiepuntenplan_vak_print')
                ->with('vak_voor_punten', $vak)
                ->with('uitvoer', $vak->uitvoer)
                ->with('opleiding', $vak->uitvoer->blok->opleiding);
    }

    public function studiepuntenplan_uitvoer(Uitvoer $uitvoer)
    {
        return view('uitvoeren.studiepuntenplan_uitvoer_print')
                ->with('uitvoer', $uitvoer)
                ->with('opleiding', $uitvoer->blok->opleiding);
    }
}
