<?php

namespace App\Http\Controllers;

use App\Models\Feedbackmoment;
use App\Models\Module;
use App\Models\ModuleVersie;
use App\Models\Opleiding;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ModuleController extends Controller
{
    public function show(Opleiding $opleiding, Module $module)
    {
        $versie = $module->versies()->orderByDesc('versie')->first();
        return redirect()->route('opleidingen.modules.show.versie', [$opleiding, $module, $versie]);
    }

    public function show_versie(Opleiding $opleiding, Module $module, ModuleVersie $versie)
    {
        return view('modules.show')
                ->with(compact('versie'))
                ->with(compact('module'))
                ->with(compact('opleiding'));
    }

    public function create_fbm(Opleiding $opleiding, Module $module, ModuleVersie $versie, Request $request)
    {
        $request->validate([
            'naam' => 'required',
            'points' => 'required|integer|min:1',
            'cesuur' => 'required|integer|min:70|max:100',
            'week' => 'required|integer|min:1|max:16',
        ]);
        
        $fbm = new Feedbackmoment();
        $fbm->naam = $request->naam;
        $fbm->points = $request->points;
        $fbm->cesuur = $request->cesuur;
        $fbm->checks = $request->checks;

        do{
            $code = strtoupper("F" . Str::random(3));
        } while(Feedbackmoment::where('code', $code)->count());

        $fbm->code = $code;
        $fbm->save();
        
        $versie->feedbackmomenten()->attach($fbm, ['week' => $request->week]);

        return redirect()->back();
    }
}
