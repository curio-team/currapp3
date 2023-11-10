<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //
        // Users
        //
        $user1 = \App\Models\User::create([
            'id'    => 'br10',
            'name'  => 'Bart Roos',
            'email' => 'b.roos@curio.nl',
            'type'  => 'teacher',
            'admin' => true,
        ]);
        $user2 = \App\Models\User::create([
            'id'    => 'ab01',
            'name'  => 'Test Kees',
            'email' => 'b.roos@curio.nl',
            'type'  => 'teacher',
        ]);

        //
        // Teams
        //
        $team = \App\Models\Team::create([
            'naam' => 'TT-SD',
        ]);
        $team->users()->attach(['br10', 'ab01']);

        //
        // Opleiding
        //
        $opleiding = \App\Models\Opleiding::create([
            'team_id' => $team->id,
            'naam'  => 'SD',
            'omschrijving'  => 'Software developer',
            'crebo' => '25604',
            'eigenaar_id' => 'br10',
            'blokken_per_jaar' => 2,
        ]);

        //
        // Vakken
        //
        \App\Models\Vak::factory()
            ->count(15)
            ->for($opleiding)
            ->create();
        \App\Models\Vak::factory()
            ->count(10)
            ->zonderOmschrijving()
            ->for($opleiding)
            ->create();

        //
        // Blokken
        //
        \App\Models\Blok::factory()
            ->count(8)
            ->state(new Sequence(
                ['eigenaar_id' => 'br10'],
                ['eigenaar_id' => 'ab01'],
                ['eigenaar_id' => null],
                ['eigenaar_id' => null],
            ))
            ->for($opleiding)
            ->create();

        //
        // Cohorten
        //
        foreach(\App\Models\Opleiding::all() as $opleiding)
        {
            for($i = 2020; $i <= 2024; $i++)
            {
                \App\Models\Cohort::create([
                    'opleiding_id' => $opleiding->id,
                    'naam' => 'C' . substr($i, 2, 2) . ' (4jr-sep)',
                    'datum_start' => $i . '-08-01',
                    'datum_eind' => ($i+4) . '-07-31',
                ]);
            }
        }

        //
        // Uitvoeren
        //
        foreach(\App\Models\Cohort::all() as $cohort)
        {
            $datum = new \Carbon\Carbon($cohort->datum_start);
            $i = 1;
            foreach(\App\Models\Blok::all() as $blok)
            {
                $schooljaar = $datum->format('Y');
                if($datum->format('m') <= 6) $schooljaar -= 1;

                $cohort->uitvoeren()->create([
                    'blok_id' => $blok->id,
                    'datum_start' => $datum->format('Y-m-d'),
                    'datum_eind' => $datum->addMonths(6),
                    'schooljaar' => $schooljaar,
                    'blok_in_schooljaar' => $i,
                    'points' => 100,
                ]);

                $i++;
                if($i > 2) $i = 1;
            }
        }

        //
        // Vakken-in-uitvoer
        //
        foreach(\App\Models\Uitvoer::all() as $uitvoer)
        {
            foreach(\App\Models\Vak::inRandomOrder()->limit(4)->get() as $vak)
            {
                \App\Models\VakInUitvoer::create([
                    'vak_id' => $vak->id,
                    'uitvoer_id' => $uitvoer->id,
                    'points' => 25,
                ]);
            }
        }

        //
        // Leerlijnen
        //
        \App\Models\Leerlijn::factory()
            ->count(20)
            ->for($opleiding)
            ->state(function (array $attributes) {
                return [
                    'eigenaar_id' => fake()->randomElement(['br10', 'ab01', null]),
                ];
            })
            ->create();

        //
        // Modules
        //
        $numbers = ['I', 'II', 'III', 'IV', 'V'];
        foreach(\App\Models\Leerlijn::all() as $leerlijn)
        {
            for($i = 0; $i < rand(1, 4); $i++)
            {
                \App\Models\Module::create([
                    'leerlijn_id' => $leerlijn->id,
                    'naam'        => $leerlijn->naam . '-' . $numbers[$i],
                ]);
            }
        }

        //
        // Versies
        //
        foreach(\App\Models\Module::all() as $module)
        {
            for($i = 1; $i <= rand(1, 4); $i++)
            {
                \App\Models\ModuleVersie::create([
                    'module_id'      => $module->id,
                    'versie'         => $i,
                    'hoofdauteur_id' => fake()->randomElement(['br10', 'ab01', null, null, null]),
                ]);
            }
        }

        foreach(\App\Models\VakInUitvoer::all() as $vak)
        {
            $eind = rand(3, 14);
            $versie = \App\Models\ModuleVersie::inRandomOrder()->first();
            $vak->modules()->save($versie, [
                'week_start' => 1,
                'week_eind'  => $eind,
            ]);

            $versie = \App\Models\ModuleVersie::inRandomOrder()->first();
            $vak->modules()->save($versie, [
                'week_start' => $eind+1,
                'week_eind'  => 16,
            ]);
        }

        //
        // Leerdoelen
        //
        foreach(\App\Models\Leerlijn::all() as $leerlijn)
        {
            for ($i = 1; $i < rand(2, 20); $i++)
            {
               $leerdoel = new \App\Models\Leerdoel();
               $leerdoel->volgorde = $i;
               $leerdoel->nummer = $i;
               $leerdoel->tekst_lang = fake()->sentence(nbWords: 10);
               $leerdoel->tekst_kort = implode(' ', array_slice(explode(' ', $leerdoel->tekst_lang), 0, 3));
               $leerlijn->leerdoelen()->save($leerdoel);
            }
        }

        //
        // Leerdoelen aan modules en blokken
        //
        $ids = \App\Models\Leerdoel::all()->pluck('id')->toArray();
        foreach(\App\Models\ModuleVersie::all() as $versie)
        {
            $start = rand(0, count($ids) / 2);
            $end = rand($start+1, $start+20);
            $versie->leerdoelen()->attach(array_slice($ids, $start, $end));
        }
        foreach(\App\Models\Uitvoer::all() as $blok)
        {
            $start = rand(0, count($ids) / 2);
            $end = rand($start+1, $start+20);
            $blok->leerdoelen()->attach(array_slice($ids, $start, $end));
        }

        //
        // Aspecten
        //
        foreach(\App\Models\Leerdoelable::all() as $leerdoelable)
        {
            for($i = 0; $i < rand(1, 3); $i++)
            {
                $aspect = new \App\Models\Aspect();
                $aspect->voldoende = fake()->sentence(nbWords: 4);
                $leerdoelable->aspecten()->save($aspect);
            }
        }

        //
        // Acceptatiecriteria
        //
        \App\Models\Acceptatiecriterium::factory()
            ->count(25)
            ->for($opleiding)
            ->create();

        $ids = \App\Models\Acceptatiecriterium::all()->pluck('id')->toArray();
        foreach(\App\Models\ModuleVersie::limit(10)->get() as $module)
        {
            for($i = 0; $i < rand(1, 4); $i++)
            {
                $module->acceptatiecriteria()->attach(fake()->randomElement($ids), ['voldoet' => rand(0, 1)]);
            }
        }

        foreach(\App\Models\Leerlijn::all() as $leerlijn)
        {
            for($i = 0; $i < rand(5, 10); $i++)
            {
                $leerlijn->acceptatiecriteria()->attach(fake()->randomElement($ids));
            }
        }

        //
        // Feedbackmomenten
        //
        \App\Models\Feedbackmoment::factory()
            ->count(100)
            ->create();

        //
        // Feedbackmomenten aan modules
        //
        foreach(\App\Models\Feedbackmoment::all() as $moment)
        {
            $moment->modules()->attach(\App\Models\ModuleVersie::inRandomOrder()->first(), [
                'week' => rand(1, 16),
            ]);
        }
    }
}
