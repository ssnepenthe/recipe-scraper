<?php

namespace SSNepenthe\RecipeScraper\Normalizers;

use SSNepenthe\RecipeScraper\Interfaces\Normalizer;

class Number implements Normalizer {
	public function normalize(array $values) {
		return array_map(function($v) {
			$words = [
	            'twenty', 'nineteen', 'eighteen', 'seventeen', 'sixteen',
	            'fifteen', 'fourteen', 'thirteen', 'twelve', 'eleven', 'ten',
	            'nine', 'eight', 'seven', 'six', 'five', 'four', 'three', 'two',
	            'one'
	        ];

	        $digits = [
	            '20', '19', '18', '17', '16', '15', '14', '13', '12', '11',
	            '10', '9', '8', '7', '6', '5', '4', '3', '2', '1'
	        ];

	        return trim(str_replace($words, $digits, $v));
		}, $values);
	}
}
