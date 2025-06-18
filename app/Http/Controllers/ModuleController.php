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
            // 'points' => 'required|integer|min:1',
            'cesuur' => 'required|integer|min:50|max:70',
            'week' => 'required|integer|min:1',
        ]);

        $fbm = new Feedbackmoment();
        $fbm->naam = $request->naam;
        $fbm->points = 100;
        $fbm->cesuur = $request->cesuur;
        $fbm->checks = $request->checks;
        $fbm->code = Feedbackmoment::generateCode();
        $fbm->save();

        $versie->feedbackmomenten()->attach($fbm, ['week' => $request->week]);

        return redirect()->back();
    }

    public function update(Opleiding $opleiding, Module $module, Request $request)
    {
        $request->validate([
            'naam' => 'required'
        ]);

        $module->naam = $request->naam;
        $module->omschrijving = $request->omschrijving;
        $module->map_url = $request->map_url;
        $module->save();

        return redirect()->back();
    }

    public function create_version(Opleiding $opleiding, Module $module, Request $request)
    {
        $old = $module->versies()->orderByDesc('versie')->first();

        $new = new ModuleVersie();
        $new->module_id = $old->module_id;
        $new->hoofdauteur_id = $old->hoofdauteur_id;
        $new->versie = $old->versie + 1;
        $new->save();

        foreach($old->feedbackmomenten as $fbm)
        {
            $new->feedbackmomenten()->attach($fbm, ['week' => $fbm->pivot->week]);
        }

        return redirect()->route('opleidingen.modules.show.versie', [$opleiding, $module, $new]);
    }

}
