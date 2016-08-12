<?php

namespace SSNepenthe\RecipeScraper\Normalizers;

use SSNepenthe\RecipeScraper\Interfaces\Normalizer;

class Categories implements Normalizer
{
    public function normalize(array $values)
    {
        return array_map(function ($v) {
            return trim(preg_replace('/key:?/i', '', $v));
        }, $values);
    }
}
