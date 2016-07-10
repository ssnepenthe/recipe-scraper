<?php

namespace SSNepenthe\RecipeScraper\Normalizers;

use SSNepenthe\RecipeScraper\Interfaces\Normalizer;

class SingleLine implements Normalizer
{
    public function normalize(array $values)
    {
        return array_map(function ($v) {
            return trim(str_replace(PHP_EOL, ' ', $v));
        }, $values);
    }
}
