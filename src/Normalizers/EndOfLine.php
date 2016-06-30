<?php

namespace SSNepenthe\RecipeScraper\Normalizers;

use SSNepenthe\RecipeScraper\Interfaces\Normalizer;

class EndOfLine implements Normalizer {
	public function normalize(array $value) {
		return array_map(function($v) {
			return preg_replace('/\R+/u', PHP_EOL, $v);
		}, $value);
	}
}
