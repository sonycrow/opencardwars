<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class CodexServiceProvider extends ServiceProvider
{
    protected static array $codex;

    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    { }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $cards = json_decode(Storage::disk('public')->get("ocw_codex.json"), true);
        $skills = json_decode(Storage::disk('public')->get("ocw_skills.json"), true);
        foreach ($cards as $card)
        {
            $card['id']    = strtolower("{$card['universe']}-{$card['set']}{$card['number']}-{$card['version']}");
            $card['cost']  = $card['cost'] ?? self::getCost($card);

            // Recorremos las habilidades de la carta y calculamos su coste
            if (!empty($card['vanguard'])) {
                $card['vanguard']['cost'] = self::getSkillCost($card['vanguard'], $skills);
            }
            if (!empty($card['center'])) {
                $card['center']['cost'] = self::getSkillCost($card['center'], $skills);
            }
            if (!empty($card['rearguard'])) {
                $card['rearguard']['cost'] = self::getSkillCost($card['rearguard'], $skills);
            }
            if (!empty($card['extra'])) {
                $card['extra']['cost'] = self::getSkillCost($card['extra'], $skills);
            }

            self::$codex[] = $card;
        }
    }

    public static function getCard(string $id): array
    {
        foreach (self::$codex as $card) {
            if ($card['id'] == $id) {
                return $card;
            }
        }

        return array();
    }

    public static function getCards(?string $class = null): array
    {
        if (!$class) return self::$codex;

        $codex = array();
        foreach (self::$codex as $item) {
            if ($item['class'] == $class) {
                $codex[] = $item;
            }
        }

        return $codex;
    }

    public static function getName(string $id, string $lang): string
    {
        return self::getCard($id)['name'][$lang] ?? '';
    }

    public static function getVanguard(string $id, string $lang): string
    {
        return self::getCard($id)['vanguard']['desc'][$lang] ?? '';
    }

    public static function getCenter(string $id, string $lang): string
    {
        return self::getCard($id)['center']['desc'][$lang] ?? '';
    }

    public static function getRearguard(string $id, string $lang): string
    {
        return self::getCard($id)['rearguard']['desc'][$lang] ?? '';
    }
    
    public static function getExtra(string $id, string $lang): string
    {
        return self::getCard($id)['extra']['desc'][$lang] ?? '';
    }

    public static function getCost(array $card): int
    {
        $value = (0.7 * $card['hp'] / 10) + (1.2 * $card['atk'] / 4) + (0.8 * $card['def'] / 1);
        return round($value);
    }

    public static function getSkillCost(array $skill, array $skills): int
    {
        // 1. Obtener la lista de todas las habilidades
        $skill_list = $skill['skills'] ?? [];
        $desc = $skill['desc']['es'] ?? '';

        // Extraer habilidades de la descripción, ej: {stun}, {heal 4}
        // Esto captura el nombre de la habilidad, pero no su valor (si lo tiene)
        preg_match_all('/{(\w+)(?:\s+\d+)?}/i', $desc, $matches);
        if (!empty($matches[1])) {
            $skill_list = array_merge($skill_list, $matches[1]);
        }
        $skill_list = array_unique(array_map('strtolower', $skill_list));

        // 2. Encontrar el Nivel de Poder Máximo para el Coste Base
        $maxPower = 1.5;
        $primarySkill = '';
        if (!empty($skill_list)) {
            foreach ($skill_list as $item) {
                foreach ($skills as $itemSkill) {
                    if ($itemSkill['code'] == $item) {
                        $itemSkill['power'] = $itemSkill['power'] ?? 0;
                        if ($itemSkill['power'] > $maxPower) {
                            $maxPower = $itemSkill['power'];
                            $primarySkill = $item;
                        }
                    }
                }
            }
        }

        $baseCost = $maxPower * 2;

        // 3. Encontrar el boost de ataque y/o defensa
        $atk_boost = 0;
        $def_boost = 0;

        // Regex para buscar modificadores de ATK y DEF. Ej: +2#atk#, -1#def#
        preg_match_all('/([+-]\d+)\s*#atk#/i', $desc, $atk_matches);
        preg_match_all('/([+-]\d+)\s*#def#/i', $desc, $def_matches);

        if (!empty($atk_matches[1])) {
            foreach ($atk_matches[1] as $match) {
                $atk_boost += (int)$match;
            }
        }

        if (!empty($def_matches[1])) {
            foreach ($def_matches[1] as $match) {
                $def_boost += (int)$match;
            }
        }

        // 4. Calcular la suma de todos los modificadores
        $modifiers = 0;

        // Modificador por bonus de estadísticas
        $modifiers += $atk_boost / 1.2;
        $modifiers += $def_boost / 1.8;

        // Modificador por habilidades con valor X (ej: heal X, poison X)
        preg_match_all('/{(\w+)\s+(\d+)}/i', $desc, $x_matches, PREG_SET_ORDER);
        if (!empty($x_matches)) {
            foreach ($x_matches as $match) {
                // $match[2] es el valor X, ej: 4 en {heal 4}
                $x_value = (int)$match[2];
                $modifiers += $x_value / 2;
            }
        }

        // Modificador por palabras clave (Ultimate y Flash)
        if (in_array('ultimate', $skill_list)) {
            // La habilidad 'ultimate' en sí tiene un poder bajo (1), pero su presencia como tag añade +1.
            $modifiers += 1;
        }
        if (in_array('flash', $skill_list)) {
            $modifiers += 1;
        }

        // 5. Calcular el Coste Final
        $totalCost = $baseCost + $modifiers + ($skill['modifier'] ?? 0);

        return (int)round($totalCost);
    }
}
