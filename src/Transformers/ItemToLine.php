<?php

namespace SSNepenthe\RecipeScraper\Transformers;

use SSNepenthe\RecipeScraper\Interfaces\Transformer;

class ItemToLine implements Transformer
{
	public function transform(array $value)
	{
		$value = array_map(function($v) {
			return str_replace(PHP_EOL, ' ', $v);
		}, $value);

		return array_values(array_filter($value));
	}
}
