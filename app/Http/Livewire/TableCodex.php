<?php

namespace App\Http\Livewire;

use App\Http\Helpers\TranslateHelper;
use App\Providers\CodexServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;

class TableCodex extends Component
{
    // Propiedades de Datatable
    public array $props = [
        "allowSelection" => false
    ];

    public array $headers = array();
    public array $elements = array();

    /**
     * Constructor del componente
     */
    public function mount()
    {
        $this->loadHeaders();
        $this->loadElements();
    }

    /**
     * Vista del componente
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('livewire.table-codex');
    }

    /**
     * Genera las cabeceras de la tabla
     */
    private function loadHeaders(): void
    {
        $this->headers = array(
            array("key" => "id",       "value" => "ID"),
            array("key" => "image",    "value" => "Image"),
            array("key" => "name",     "value" => "Name"),
            array("key" => "set",      "value" => "Set"),
            array("key" => "number",   "value" => "Number"),
            array("key" => "universe", "value" => "Universe"),
            array("key" => "atk",      "value" => "Attack"),
            array("key" => "def",      "value" => "Defense"),
            array("key" => "cost",     "value" => "Cost"),
            array("key" => "vname",    "value" => "Vanguard"),
            array("key" => "cname",    "value" => "Center"),
            array("key" => "rname",    "value" => "Rearguard"),
        );
    }

    /**
     * Obtiene los elementos de la tabla y rellena las filas.
     */
    private function loadElements(): void
    {
        // Init
        $elements = CodexServiceProvider::getCards();
        $skills   = json_decode(Storage::disk('public')->get("ocw_skills.json"), true);
        $traits   = json_decode(Storage::disk('public')->get("ocw_traits.json"), true);

        // Formateamos elementos
        foreach ($elements as &$element)
        {
            $element['image'] = "img:/card/" . Str::lower($element['set'] . $element['number'] . '-' . $element['universe'] . '-' . $element['version'] . '-' . session('locale')) . ".jpg" . ",w:96";
            $element['name']  = CodexServiceProvider::getName($element['id'], session('locale'));
            $element['vname'] = TranslateHelper::help($skills, $traits, $this->getSkills($element['vanguard']['skills'])  . CodexServiceProvider::getVanguard($element['id'], session('locale')), session('locale'));
            $element['cname'] = TranslateHelper::help($skills, $traits, $this->getSkills($element['center']['skills'])    . CodexServiceProvider::getCenter($element['id'], session('locale')), session('locale'));
            $element['rname'] = TranslateHelper::help($skills, $traits, $this->getSkills($element['rearguard']['skills']) . CodexServiceProvider::getRearguard($element['id'], session('locale')), session('locale'));
        }

        $this->elements = $this->orderElements($this->headers, $elements);
    }

    /**
     * Limpia y ordena el diccionario de elementos.
     *
     * @param array $headers
     * @param array $elements
     * @return array
     */
    private function orderElements(array $headers, array $elements): array
    {
        $final = array();

        foreach ($elements as $element)
        {
            $felement = array();

            foreach ($headers as $header) {
                $felement[$header['key']] = null;

                foreach ($element as $key => $value) {
                    if ($header['key'] == $key) {
                        $felement[$key] = $value;
                        break;
                    }
                }
            }
            $final[] = $felement;
        }

        return $final;
    }

    private function getSkills($skills): string {
        $strSkills = null;

        if ($skills) {
            foreach ($skills as $skill) {
                $strSkills .= "{" . $skill . "}";
            }
        }

        return $strSkills ? trim($strSkills) . "<hr>" : "";
    }
}

