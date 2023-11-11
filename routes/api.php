<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('feedbackmomenten')->group(function () {
        Route::get('active-sorted-by-module', function () {
            return App\Models\Uitvoer::with('vakken.modules.parent', 'vakken.modules.feedbackmomenten')
                ->where('datum_start', '<=', now())
                ->where('datum_eind', '>=', now())
                ->get()
                ->map(function ($uitvoer) {
                    return [
                        'blok' => $uitvoer->blok->naam,
                        'datum_start' => $uitvoer->datum_start,
                        'datum_eind' => $uitvoer->datum_eind,
                        'vakken' => $uitvoer->vakken->map(function ($vak) {
                            return [
                                'vak' => $vak->parent->naam,
                                'volgorde' => $vak->parent->volgorde,
                                'modules' =>  $vak->modules->map(function ($module) {
                                    return [
                                        'module' => $module->parent->naam,
                                        'versie' => $module->versie,
                                        'leerlijn' => $module->parent->leerlijn->naam,
                                        'week_start' => $module->pivot->week_start,
                                        'week_eind' => $module->pivot->week_eind,
                                        'feedbackmomenten' => $module->feedbackmomenten->map(function ($fbm) {
                                            return [
                                                'code' => $fbm->code,
                                                'naam' => $fbm->naam,
                                                'week' => $fbm->pivot->week,
                                                'points' => $fbm->points,
                                            ];
                                        })
                                        ->sortBy('week')
                                        ->values(),
                                    ];
                                })
                                ->sortBy('week_start'),
                            ];
                        }),
                    ];
                });
        });
    });
});
