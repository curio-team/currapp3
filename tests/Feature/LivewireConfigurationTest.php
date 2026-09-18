<?php

namespace Tests\Feature;

use App\Livewire\Cohorten;
use App\Models\Opleiding;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LivewireConfigurationTest extends TestCase
{
    use RefreshDatabase;

    public function test_legacy_model_binding_is_enabled(): void
    {
        $this->assertTrue(config('livewire.legacy_model_binding'));
    }

    public function test_cohort_create_accepts_filled_item_fields(): void
    {
        $team = new Team;
        $team->naam = 'Team A';
        $team->save();

        $opleiding = new Opleiding;
        $opleiding->team_id = $team->id;
        $opleiding->eigenaar_id = 'ab01';
        $opleiding->naam = 'Software Developer';
        $opleiding->blokken_per_jaar = 4;
        $opleiding->save();

        Livewire::test(Cohorten::class, ['opleiding' => $opleiding])
            ->set('item.naam', 'C26')
            ->set('item.datum_start', '2026-08-01')
            ->set('item.datum_eind', '2031-07-31')
            ->call('create')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('cohorten', [
            'opleiding_id' => $opleiding->id,
            'naam' => 'C26',
            'datum_start' => '2026-08-01',
            'datum_eind' => '2031-07-31',
        ]);
    }
}
