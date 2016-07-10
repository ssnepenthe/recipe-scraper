<?php

namespace SSNepenthe\RecipeScraper\Normalizers;

use SSNepenthe\RecipeScraper\Interfaces\Normalizer;

/**
 * @todo Might be better to just look for digits and extract them?
 *       Would be required to have run through number normalizer first though.
 */
class RecipeYield implements Normalizer
{
    public function normalize(array $values)
    {
        return array_map(function ($v) {
            return trim(preg_replace(
                [
                    // Everything in parens - handles serving size for myrecipes.com.
                    '/\(.*\)/',
                    // Misc. keywords, space and punctuation.
                    '/\s?(guest|make|serve|serving|yield)s?:?\.?\s?/i',
                ],
                '',
                $v
            ));
        }, $values);
    }
}
