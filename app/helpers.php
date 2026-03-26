<?php

use App\Models\Cohort;
use App\Services\WeeksApi;

if (! function_exists('user')) {
    /**
     * Get the currently logged in user model.
     */
    function user(): ?\App\Models\User
    {
        return auth()->user();
    }
}

if (! function_exists('weeks_api_url')) {
    /**
     * Build a URL to the weeks API.
     */
    function weeks_api_url(string $path = ''): string
    {
        $apiUrl = config('app.weeks.api_url');

        if ($path && $path[0] === '/') {
            $path = substr($path, 1);
        }

        if ($apiUrl && substr($apiUrl, -1) !== '/') {
            $apiUrl .= '/';
        }

        return $apiUrl . $path;
    }
}

if (! function_exists('getUitvoer')) {
    function getUitvoer(Cohort $cohort, string $uitvoer_id)
    {
        $uitvoerId = intval($uitvoer_id);

        $cohortNumeric = preg_match('/\D*([0-9]{2,})/', $cohort->naam, $matches);
        $cohortNumeric = $matches[1];
        $week = WeeksApi::get('/cohort/' . $cohortNumeric);

        if ($uitvoerId === -1) {
            $schooljaar = substr($week['schooljaar']['start'], 0, 4);
            $volgorde = $week['semester']['volgorde'];

            $uitvoer = $cohort->uitvoeren()
                ->where('schooljaar', $schooljaar)
                ->where('blok_in_schooljaar', $volgorde)
                ->with('blok')
                ->first();
        } else {
            $uitvoer = $cohort->uitvoeren()
                ->with('blok')
                ->findOrFail($uitvoerId);
        }

        if (! $uitvoer) {
            return response()->json([
                'message' => 'Geen actieve uitvoer gevonden voor dit cohort',
            ], 404);
        }

        $output = [
            'id' => $uitvoer->id,
            'blok' => $uitvoer->blok->naam,
            'currentWeek' => $week['week']['nummer'],
            'datum_start' => $uitvoer->datum_start,
            'datum_eind' => $uitvoer->datum_eind,
            'vakken' => $uitvoer->vakken->map(function ($vak) {
                $feedbackmomenten = [];

                foreach ($vak->modules as $module) {
                    foreach ($module->feedbackmomenten as $fbm) {
                        if (($fbm->pivot->week >= $module->pivot->week_start) && ($fbm->pivot->week <= $module->pivot->week_eind)) {
                            $feedbackmomenten[] = [
                                'id' => $fbm->id,
                                'code' => $fbm->code,
                                'naam' => $fbm->naam,
                                'week' => $fbm->pivot->week,
                                'points' => $fbm->points,
                                'cesuur' => $fbm->cesuur,
                            ];
                        }
                    }
                }

                usort($feedbackmomenten, function ($a, $b) {
                    if ($a['week'] == $b['week']) {
                        return 0;
                    }

                    return ($a['week'] < $b['week']) ? -1 : 1;
                });

                return [
                    'uitvoer_id' => $vak->id,
                    'vak' => $vak->parent->naam,
                    'volgorde' => $vak->parent->volgorde,
                    'feedbackmomenten' => $feedbackmomenten,
                ];
            }),
        ];

        return $output;
    }
}
