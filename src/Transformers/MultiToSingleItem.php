<?php

namespace SSNepenthe\RecipeScraper\Transformers;

use SSNepenthe\RecipeScraper\Interfaces\Transformer;

class MultiToSingleItem implements Transformer
{
	public function transform(array $value)
	{
		return [implode(' ', $value)];
	}
}
