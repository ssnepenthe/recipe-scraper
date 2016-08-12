<?php

namespace SSNepenthe\RecipeScraper\Normalizers;

use SSNepenthe\RecipeScraper\Interfaces\Normalizer;

class RecipeInstructions implements Normalizer
{
    public function normalize(array $values)
    {
        return array_filter($values, function ($v) {
            if (1 === preg_match('/photograph(s|y)? by/i', $v)) {
                return false;
            }

            if (false !== strpos($v, 'Per serving: ')) {
                return false;
            }

            if (false !== strpos($v, 'Copyright')) {
                return false;
            }

            return true;
        });
    }
}
