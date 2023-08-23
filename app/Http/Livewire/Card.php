<?php

namespace App\Http\Livewire;

use App\Http\Helpers\DescriptionHelper;
use App\Http\Helpers\TranslateHelper;
use App\Providers\CodexServiceProvider;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Card extends Component
{
    public array $card;
    public string $lang;

    /**
     * Constructor del componente
     */
    public function mount(string $id)
    {
        // Tablas
        $skills = json_decode(Storage::disk('public')->get("ocw_skills.json"), true);
        $traits = json_decode(Storage::disk('public')->get("ocw_traits.json"), true);

        // Datos generales
        $this->lang = session('locale');

        // Datos de la unidad
        $this->card = CodexServiceProvider::getCard($id);

        // Transformamos textos
        $this->card['type']  = DescriptionHelper::help($traits, $this->card['type'],  $this->lang);
        $this->card['class'] = DescriptionHelper::help($traits, $this->card['class'], $this->lang);

        foreach ($this->card['traits'] as &$item) {
            $item = DescriptionHelper::help($traits, $item, $this->lang) ?? $item;
        }
        foreach ($this->card['skills'] as &$item) {
            $item = DescriptionHelper::help($skills, $item, $this->lang) ?? $item;
        }

        foreach ($this->card['vanguard']['skills'] as &$item) {
            $item = DescriptionHelper::help($traits, $item, $this->lang) ?? $item;
            $item = DescriptionHelper::help($skills, $item, $this->lang) ?? $item;
        }
        foreach ($this->card['center']['skills'] as &$item) {
            $item = DescriptionHelper::help($traits, $item, $this->lang) ?? $item;
            $item = DescriptionHelper::help($skills, $item, $this->lang) ?? $item;
        }
        foreach ($this->card['rearguard']['skills'] as &$item) {
            $item = DescriptionHelper::help($traits, $item, $this->lang) ?? $item;
            $item = DescriptionHelper::help($skills, $item, $this->lang) ?? $item;
        }

        $this->card['vanguard']['desc'][$this->lang]  = TranslateHelper::help($skills, $traits, $this->card['vanguard']['desc'][$this->lang],  $this->lang);
        $this->card['center']['desc'][$this->lang]    = TranslateHelper::help($skills, $traits, $this->card['center']['desc'][$this->lang],    $this->lang);
        $this->card['rearguard']['desc'][$this->lang] = TranslateHelper::help($skills, $traits, $this->card['rearguard']['desc'][$this->lang], $this->lang);
    }

    /**
     * Vista del componente
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.card');
    }

}
