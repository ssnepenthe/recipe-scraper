<?php

namespace SSNepenthe\RecipeScraper\Normalizers;

use SSNepenthe\RecipeScraper\Interfaces\Normalizer;

class SpaceBetweenSentences implements Normalizer
{
    public function normalize(array $values)
    {
        return array_map(function ($v) {
            return trim(preg_replace('/([\.\)])([\w\d])/', '$1 $2', $v));
        }, $values);
    }
}
