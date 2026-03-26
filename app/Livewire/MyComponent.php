<?php

namespace App\Livewire;

use Livewire\Component;

class MyComponent extends Component
{
    protected $listeners = ['refreshComponent' => '$refresh'];

    public $item;

    public function mount()
    {
        $this->item = new $this->className;
    }

    public function setItem($id)
    {
        $this->item = $this->className::find($id);
    }

    public function clearItem()
    {
        $this->item = new $this->className;
    }

    protected function endModal()
    {
        $this->clearItem();
        $this->dispatch('confirm');
        $this->dispatch('refreshComponent');
    }
}
