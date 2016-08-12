<?php

namespace SSNepenthe\RecipeScraper\Normalizers;

use SSNepenthe\RecipeScraper\Interfaces\Normalizer;

class Name implements Normalizer
{
    public function normalize(array $values)
    {
        return array_map(function ($v) {
            return trim(
            	// For myrecipes.com.
            	preg_replace('/recipe$/i', '', $v)
            );
        }, $values);
    }
}
