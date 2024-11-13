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
        foreach ($cards as $card)
        {
            $card['id']   = strtolower("{$card['universe']}-{$card['set']}{$card['number']}-{$card['version']}-" . App::currentLocale());
            $card['cost'] = self::getCost($card);
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

    public static function getCost(array $card): int
    {
        $value = (0.7 * $card['hp'] / 15) + (1.2 * $card['atk'] / 4) + (0.8 * $card['def'] / 1);
        return round($value);
    }
}
