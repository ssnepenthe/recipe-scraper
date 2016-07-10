<?php

namespace SSNepenthe\RecipeScraper\Normalizers;

use SSNepenthe\RecipeScraper\Interfaces\Normalizer;

class Fraction implements Normalizer {
	public function normalize(array $values) {
		return array_map(function($v) {
			// Add a space if necessary, "1¼" -> "1 ¼"
	        $v = preg_replace(
	            '/(\d+)([⅛|¼|⅓|⅜|½|⅝|⅔|¾|⅞])/',
	            '$1 $2',
	            $v
	        );

	        // Then replace the fraction.
	        $v = str_replace(
	            [ '⅛', '¼', '⅓', '⅜', '½', '⅝', '⅔', '¾', '⅞' ],
	            [ '1/8', '1/4', '1/3', '3/8', '1/2', '5/8', '2/3', '3/4', '7/8' ],
	            $v
	        );

	        return trim($v);
		}, $values);
	}
}
