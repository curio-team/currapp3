<?php

namespace App\Http\Controllers;

use App\Models\Opleiding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OpleidingController extends Controller
{
    public function show(Opleiding $opleiding)
    {
        $week = Http::get(weeks_api_url())->json();
        $schooljaar = substr($week['schooljaar']['start'] , 0, 4);
        $volgorde = $week['semester']['volgorde'];

        $prev_volgorde = ($volgorde == 2) ? 1 : 2;
        $prev_schooljaar = ($volgorde == 2) ? $schooljaar : $schooljaar-1;

        $next_volgorde = ($volgorde == 2) ? 1 : 2;
        $next_schooljaar = ($volgorde == 2) ? $schooljaar+1 : $schooljaar;

        $uitvoeren_verleden = $opleiding->uitvoeren()
                                        ->where('schooljaar', $prev_schooljaar)
                                        ->where('blok_in_schooljaar', $prev_volgorde)
                                        ->orderBy('blokken.volgorde')
                                        ->get();

        $uitvoeren_actueel = $opleiding->uitvoeren()
                                        ->where('schooljaar', $schooljaar)
                                        ->where('blok_in_schooljaar', $volgorde)
                                        ->orderBy('blokken.volgorde')
                                        ->get();

        $uitvoeren_toekomst = $opleiding->uitvoeren()
                                        ->where('schooljaar', $next_schooljaar)
                                        ->where('blok_in_schooljaar', $next_volgorde)
                                        ->orderBy('blokken.volgorde')
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
