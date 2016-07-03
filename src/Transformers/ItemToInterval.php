<?php

namespace SSNepenthe\RecipeScraper\Transformers;

use SSNepenthe\RecipeScraper\Interfaces\Transformer;

class ItemToInterval implements Transformer
{
	public function transform(array $value)
	{
		$value = array_map(function($v) {
			try {
				$interval = new \DateInterval($v);
			} catch (\Exception $e) {
				$interval = \DateInterval::createFromDateString($v);
			}

			// Did DateInterval::createFromDateString create an empty interval?
			if (
				! $interval->y && ! $interval->m && ! $interval->d &&
				! $interval->h && ! $interval->i && ! $interval->s
			) {
				$interval = null;
			}

			return $interval;
		}, $value);

		return array_values(array_filter($value));
	}
}
