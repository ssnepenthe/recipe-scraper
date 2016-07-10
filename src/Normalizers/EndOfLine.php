<?php

namespace SSNepenthe\RecipeScraper\Normalizers;

use SSNepenthe\RecipeScraper\Interfaces\Normalizer;

class EndOfLine implements Normalizer
{
    public function normalize(array $values)
    {
        return array_map(function ($v) {
            return trim(preg_replace('/\R+/u', PHP_EOL, $v));
        }, $values);
    }
}
