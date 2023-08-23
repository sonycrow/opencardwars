<?php

namespace App\Http\Helpers;

class TranslateHelper
{
    static public function help($skills, $traits, $text, $lang): string
    {
        $text = preg_replace_callback(
            '/\{(.*?)}/mi',
            function ($m) use ($skills, $lang) {
                return "{" . DescriptionHelper::help($skills, $m[1], $lang) . "}";
            },
            $text
        );

        $text = preg_replace_callback(
            '/\[(.*?)]/mi',
            function ($m) use ($traits, $lang) {
                return "[" . DescriptionHelper::help($traits, $m[1], $lang) . "]";
            },
            $text
        );

        $text = str_replace('\n', '<br/>', $text);
        return $text;
    }
}
