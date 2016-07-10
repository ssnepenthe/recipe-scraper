<?php

namespace SSNepenthe\RecipeScraper\Transformers;

use SSNepenthe\RecipeScraper\Interfaces\Transformer;

class StringsToIntervals implements Transformer
{
	public function transform(array $values)
	{
		$values = array_values(array_filter(array_map(function($v) {
			// Remove spaces from interval string (for justataste.com).
			$v = str_replace(' ', '', $v);

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
		}, $values)));

		return $values;
	}
}
