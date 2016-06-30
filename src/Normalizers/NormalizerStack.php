<?php

namespace SSNepenthe\RecipeScraper\Normalizers;

use SSNepenthe\RecipeScraper\Interfaces\Normalizer;

class NormalizerStack {
	protected $normalizers = [];

	public function push(Normalizer $normalizer) {
		$this->normalizers[] = $normalizer;
	}

	public function normalize(array $value) {
		foreach ($this->normalizers as $normalizer) {
			$value = $normalizer->normalize($value);
		}

		return $value;
	}
}
