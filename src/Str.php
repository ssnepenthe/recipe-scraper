<?php

namespace RecipeScraper;

use Stringy\Stringy;

class Str
{
    /**
     * @param  string $value
     * @return string
     */
    public static function normalize(string $value) : string
    {
        return Stringy::create($value)
            ->htmlDecode()
            ->tidy()
            ->trim()
            ->collapseWhitespace()
            ->__toString();
    }
}
