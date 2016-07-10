<?php

namespace SSNepenthe\RecipeScraper\Transformers;

use SSNepenthe\RecipeScraper\Interfaces\Transformer;

class NullTransformer implements Transformer
{
	public function transform(array $values)
	{
		return $values;
	}
}
