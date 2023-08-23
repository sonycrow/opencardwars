<?php

namespace App\Http\Helpers;

class DescriptionHelper
{
    static public function help($items, $code, $lang): ?string
    {
        foreach ($items as $item) {
            if (strtolower($item["code"]) == strtolower(preg_replace('/[0-9]/', 'x', $code))) {
                preg_match('/.*?([0-9])/', $code, $match, PREG_UNMATCHED_AS_NULL);
                return strtolower(str_ireplace(" x", "", $item["code"])) . "|" . strtolower(str_ireplace(" x", (!empty($match[1]) ? " {$match[1]}" : null), $item["name"][$lang]));
            }
        }

        return null;
    }
}
