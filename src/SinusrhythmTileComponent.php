<?php

namespace Schruptor\Sinusrhythm;

use Livewire\Component;
use Illuminate\View\Factory;

class SinusrhythmTileComponent extends Component
{
    public string $position;

    public function mount(string $position)
    {
        $this->position = $position;
    }

    public function render(Factory $view)
    {
        return $view->make('dashboard-sinusrhythm-tile::tile', [
            'status' => (StatusStore::make())->getStatus(),
        ]);
    }
}
