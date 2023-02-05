<?php

namespace App\Http\Controllers;

use App\Models\Opleiding;
use Illuminate\Http\Request;

class OpleidingController extends Controller
{
    public function show(Opleiding $opleiding)
    {
        $today = new \Carbon\CarbonImmutable();
        $maanden_per_blok = 11 / $opleiding->blokken_per_jaar;
        $dagen = 28 * ($maanden_per_blok - floor($maanden_per_blok));
        
        $prev_period = $today->subMonths($maanden_per_blok)->subDays($dagen);
        if($prev_period->month == 8) $prev_period = $prev_period->subMonth();

        $next_period = $today->addMonths($maanden_per_blok)->subDays($dagen);
        if($next_period->month == 8) $next_period = $next_period->addMonth();

        $uitvoeren_verleden = $opleiding->uitvoeren()
                                        ->whereDate('uitvoeren.datum_start', '<=', $prev_period)
                                        ->whereDate('uitvoeren.datum_eind', '>=', $prev_period)
                                        ->get();

        $uitvoeren_actueel = $opleiding->uitvoeren()
                                        ->whereDate('uitvoeren.datum_start', '<=', $today)
                                        ->whereDate('uitvoeren.datum_eind', '>=', $today)
                                        ->get();

        $uitvoeren_toekomst = $opleiding->uitvoeren()
                                        ->whereDate('uitvoeren.datum_start', '<=', $next_period)
                                        ->whereDate('uitvoeren.datum_eind', '>=', $next_period)
                                        ->get();

        return view('opleidingen.show')
            ->with('opleiding', $opleiding)
            ->with('uitvoeren_verleden', $uitvoeren_verleden)
            ->with('uitvoeren_actueel', $uitvoeren_actueel)
            ->with('uitvoeren_toekomst', $uitvoeren_toekomst);
    }

    public function edit(Opleiding $opleiding)
    {
        //
    }

    public function update(Request $request, Opleiding $opleiding)
    {
        //
    }

    public function destroy(Opleiding $opleiding)
    {
        //
    }
}
