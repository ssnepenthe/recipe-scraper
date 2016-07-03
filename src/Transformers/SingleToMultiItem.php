<?php

namespace SSNepenthe\RecipeScraper\Transformers;

use SSNepenthe\RecipeScraper\Interfaces\Transformer;

class SingleToMultiItem implements Transformer
{
	public function transform(array $values)
	{
		$return = [];
		$values = array_map(function($v) {
			return explode(PHP_EOL, $v);
		}, $values);

		foreach ($values as $value) {
			$return = array_merge($return, $value);
		}

		return $return;
	}
}
