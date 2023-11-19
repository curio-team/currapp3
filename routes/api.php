<?php

use App\Models\Cohort;
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
                        'id' => $uitvoer->id,
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
                                        'version_number' => $module->versie,
                                        'version_id' => $module->id,
                                        'leerlijn' => $module->parent->leerlijn->naam,
                                        'week_start' => $module->pivot->week_start,
                                        'week_eind' => $module->pivot->week_eind,
                                        'feedbackmomenten' => $module->feedbackmomenten->map(function ($fbm) {
                                            return [
                                                'id' => $fbm->id,
                                                'code' => $fbm->code,
                                                'naam' => $fbm->naam,
                                                'week' => $fbm->pivot->week,
                                                'points' => $fbm->points,
                                                'cesuur' => $fbm->cesuur,
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

    Route::prefix('cohorts')->group(function () {
        Route::get('/', function () {
            return Cohort::orderBy('naam', 'desc')->get();
        });

        Route::get('/{cohort}/active-uitvoer', function (Cohort $cohort) {

            $uitvoer = $cohort->uitvoeren()
                    ->where('datum_start', '<=', now())
                    ->where('datum_eind', '>=', now())
                    ->with('blok')
                    ->first();

            $output = array (
                'id' => $uitvoer->id,
                'blok' => $uitvoer->blok->naam,
                'datum_start' => $uitvoer->datum_start,
                'datum_eind' => $uitvoer->datum_eind,
                'vakken' => $uitvoer->vakken->map(function ($vak) {

                    $feedbackmomenten = array();
                    foreach($vak->modules as $module)
                    {
                        foreach($module->feedbackmomenten as $fbm)
                        {
                            if(($fbm->pivot->week >= $module->pivot->week_start) && ($fbm->pivot->week <= $module->pivot->week_eind))
                            {
                                $feedbackmomenten[] = array(
                                    'id' => $fbm->id,
                                    'code' => $fbm->code,
                                    'naam' => $fbm->naam,
                                    'week' => $fbm->pivot->week,
                                    'points' => $fbm->points,
                                    'cesuur' => $fbm->cesuur,
                                );
                            }
                        }
                    }

                    usort($feedbackmomenten, function ($a, $b) {
                        if($a['week'] == $b['week']) return 0;
                        return ($a['week'] < $b['week']) ? -1 : 1;
                    });

                    return [
                        'vak' => $vak->parent->naam,
                        'volgorde' => $vak->parent->volgorde,
                        'feedbackmomenten' => $feedbackmomenten,
                    ];
                }),
            );

            return $output;

        });
    });
});
