<?php

namespace SSNepenthe\RecipeScraper\Normalizers;

use SSNepenthe\RecipeScraper\Interfaces\Normalizer;

class OrderedList implements Normalizer
{
    public function normalize(array $values)
    {
        return array_map(function ($v) {
            // Replace leading digit(s) with optional period.
            return trim(preg_replace('/^\d+\.?\s+/', '', $v));
        }, $values);
    }
}
