<?php

namespace SSNepenthe\RecipeScraper\Normalizers;

use SSNepenthe\RecipeScraper\Interfaces\Normalizer;

/**
 * @todo Might be better to just look for digits and extract them?
 *       Would be required to have run through number normalizer first though.
 */
class RecipeYield implements Normalizer {
    public function normalize(array $value) {
        return array_map(function($v) {
            return trim(preg_replace(
                [
                    '/\(.*\)/', // Serving size (aka everything in parens) for myrecipes.com.
                    '/\s?(make|serve|serving|yield)s?:?\.?\s?/i', // Misc. keywords, space and punctuation.
                ],
                '',
                $v
            ));
        }, $value);
    }
}
