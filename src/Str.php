<?php

namespace RecipeScraper;

use function Stringy\create as s;

class Str
{
	/**
	 * @param  string $value
	 * @return string
	 */
    public static function normalize(string $value) : string
    {
        return s($value)
            ->htmlDecode()
            ->tidy()
            ->trim()
            ->collapseWhitespace()
            ->__toString();
    }
}
