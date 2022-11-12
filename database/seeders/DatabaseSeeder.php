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
        ]);
        $user2 = \App\Models\User::create([
            'id'    => 'ab01',
            'name'  => 'Test Kees',
            'email' => 'b.roos@curio.nl',
            'type'  => 'teacher',
        ]);

        //
        // Opleiding
        //
        $opleiding = \App\Models\Opleiding::create([
            'naam'  => 'Software developer',
            'crebo' => '25604',
            'eigenaar_id' => 'br10',
            'duur_in_jaren' => 4,
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
            $datum = $cohort->datum_start;
            foreach(\App\Models\Blok::all() as $blok)
            {
                \App\Models\Uitvoer::create([
                    'cohort_id' => $cohort->id,
                    'blok_id' => $blok->id,
                    'datum_start' => $datum->format('Y-m-d'),
                    'datum_eind' => $datum->addMonths(6),
                ]);
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
                ]);
            }
        }

        //
        // Leerlijnen
        //
        \App\Models\Leerlijn::factory()
            ->count(20)
            ->for($opleiding)
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
                    'eigenaar_id' => fake()->randomElement(['br10', 'ab01', null]),
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
            for ($i = 1; $i < rand(2, 5); $i++)
            { 
                $versie = new \App\Models\ModuleVersie();
                $versie->module_id = $module->id;
                $versie->versie = $i;
                $versie->hoofdauteur_id = fake()->randomElement(['br10', 'ab01', null, null, null]);
                \App\Models\VakInUitvoer::inRandomOrder()->first()->modules()->save($versie, [
                    'week_start' => rand(1, 8),
                    'week_eind'  => rand(9, 16),
                ]);
            }
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
    }
}
