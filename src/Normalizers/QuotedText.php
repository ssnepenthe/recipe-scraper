<?php

namespace SSNepenthe\RecipeScraper\Normalizers;

use SSNepenthe\RecipeScraper\Interfaces\Normalizer;

/**
 * Mostly for AllRecipes where the description tends to be wrapped in quotes.
 */
class QuotedText implements Normalizer
{
    public function normalize(array $values)
    {
        return array_map(function ($v) {
            return trim($v, " \"\t\n\r\0\x0B");
        }, $values);
    }
}
