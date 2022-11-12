<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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

    }
}
