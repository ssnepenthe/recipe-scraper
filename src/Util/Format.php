<?php

namespace SSNepenthe\RecipeParser\Util;

class Format
{
    public static function line($value)
    {
        $value = Normalize::whiteSpace($value);
        $value = str_replace(PHP_EOL, ' ', $value);

        return trim($value);
    }

    public static function listFromLine($value)
    {
        $value = Normalize::whiteSpace($value);

        return array_map('trim', explode(PHP_EOL, $value));
    }
}
