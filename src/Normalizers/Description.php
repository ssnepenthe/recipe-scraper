<?php

namespace SSNepenthe\RecipeScraper\Normalizers;

use SSNepenthe\RecipeScraper\Interfaces\Normalizer;

class Description implements Normalizer
{
    public function normalize(array $values)
    {
        return array_map(function ($v) {
            return trim(
            	// For justataste.com.
            	preg_replace('/\[.*\]/', '', $v)
            );
        }, $values);
    }
}
