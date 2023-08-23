<?php

namespace App\Http\Livewire;

use Livewire\Component;

class UnitGenerator extends Component
{
    public string $faction = "-";

    public bool $tts = false;
    public bool $images = false;
    public bool $download = false;

    /**
     * Vista del componente
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.unit-generator');
    }

}
