<?php

namespace Tests\Feature;

use Tests\TestCase;

class LivewireConfigurationTest extends TestCase
{
    public function test_legacy_model_binding_is_enabled(): void
    {
        $this->assertTrue(config('livewire.legacy_model_binding'));
    }
}
