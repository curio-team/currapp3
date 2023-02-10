<?php

namespace App\Http\Controllers;

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

    public function link_vak(Uitvoer $uitvoer, Request $request)
    {
        foreach($request->vakken as $vak_id)
        {
            if($uitvoer->vakken->doesntContain('vak_id', $vak_id))
            {
                $vak = new VakInUitvoer();
                $vak->vak_id = $vak_id;
                $vak->uitvoer_id = $uitvoer->id;
                $vak->save();
            }
        }

        $vakken = collect($request->vakken);
        foreach($uitvoer->vakken as $vak)
        {
            if($vakken->doesntContain($vak->vak_id))
            {
                $vak->modules()->detach();
                $vak->delete();
            }
        }

        return redirect()->back();
    }
}
