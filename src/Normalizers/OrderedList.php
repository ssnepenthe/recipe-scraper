<?php

namespace SSNepenthe\RecipeScraper\Normalizers;

use SSNepenthe\RecipeScraper\Interfaces\Normalizer;

class OrderedList implements Normalizer {
	public function normalize(array $value) {
		return array_map(function($v) {
			// Replace leading digit with optional period.
			return preg_replace('/^\d+[\)\.:]\s+/', '', $v);
		}, $value);
	}
}
