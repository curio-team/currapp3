<?php

namespace App\Http\Controllers;

use App\Models\Opleiding;
use Illuminate\Http\Request;

class RapportController extends Controller
{
    public function llc(Opleiding $opleiding)
    {
        $today = new \Carbon\CarbonImmutable();
        $uitvoeren_actueel = $opleiding->uitvoeren()
                                        ->whereDate('uitvoeren.datum_start', '<=', $today)
                                        ->whereDate('uitvoeren.datum_eind', '>=', $today)
                                        ->get();

        $per_vak = [];
        foreach($uitvoeren_actueel as $uitvoer)
        {
            $blok = $uitvoer->blok->naam;
            foreach($opleiding->vakken as $vak)
            {
                $per_vak[$vak->naam][$blok] = "";
            }

            foreach($uitvoer->vakken as $vak)
            {
                $per_vak[$vak->parent->naam][$blok] = $vak->eigenaars;
            }
        }

        return view('rapportages.llc')
                ->with('opleiding', $opleiding)
                ->with('per_vak', collect($per_vak));

    }

    public function llc2(Opleiding $opleiding)
    {
        $per_eigenaar = $opleiding->leerlijnen->groupBy('eigenaar_id')->toArray();
        ksort($per_eigenaar);

        return view('rapportages.llc2')
                ->with('opleiding', $opleiding)
                ->with('per_eigenaar', $per_eigenaar);
    }
}
