<?php

namespace SSNepenthe\RecipeScraper\Normalizers;

use SSNepenthe\RecipeScraper\Interfaces\Normalizer;

class NormalizerStack {
	protected $normalizers = [];

	public function push(Normalizer $normalizer) {
		$this->normalizers[] = $normalizer;
	}

	public function normalize(array $values) {
		foreach ($this->normalizers as $normalizer) {
			$values = $normalizer->normalize($values);
		}

		// Remove falsey values and reindex before returning.
		return array_values(array_filter($values));
	}
}
