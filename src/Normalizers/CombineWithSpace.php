<?php

namespace SSNepenthe\RecipeScraper\Normalizers;

use SSNepenthe\RecipeScraper\Interfaces\Normalizer;

class CombineWithSpace implements Normalizer
{
    public function normalize(array $values)
    {
        return [implode(' ', $values)];
    }
}
