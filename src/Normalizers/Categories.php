<?php

namespace SSNepenthe\RecipeScraper\Normalizers;

use SSNepenthe\RecipeScraper\Interfaces\Normalizer;

class Categories implements Normalizer {
	public function normalize(array $values) {
		return array_map(function($v) {
			return trim(str_ireplace('Key', '', $v), ": \t\n\r\0\x0B");
		}, $values);
	}
}
