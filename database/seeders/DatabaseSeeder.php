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
        
    }
}
