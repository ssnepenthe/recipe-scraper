<?php

namespace SSNepenthe\RecipeScraper\Transformers;

use SSNepenthe\RecipeScraper\Interfaces\Transformer;

class ListToGroupedList implements Transformer
{
	public function transform(array $values)
	{
		$titles = [];

        foreach ($values as $key => $value) {
            if (! $this->looksLikeGroupTitle($value)) {
                continue;
            }

            $titles[] = $key;
        }

        if (empty($titles)) {
            return [ [
                'title' => '',
                'data' => $values,
            ] ];
        }

        $groups = [];
        $count = count($titles);
        $counter = 0;

        // There are titles, but the first group is title-less.
        if (0 !== $titles[0]) {
            $groups[] = [
                'title' => '',
                'data' => array_slice($values, 0, $titles[0])
            ];
        }

        foreach ($titles as $key => $position) {
            $counter++;

            // Remove colon and extra space, capitalize first letter of words.
            $title = ucwords(strtolower(trim(str_replace(
            	':',
            	'',
            	$values[ $position ]
            ))));

            $groups[] = [
                'title' => $title,
                'data' => array_slice(
                    $values,
                    $position + 1,
                    $counter === $count ? null : $titles[ $key + 1 ] - ( $position + 1 )
                )
            ];
        }

        return $groups;
	}

	protected function looksLikeGroupTitle($value)
    {
        if (':' === substr($value, -1)) {
            return true;
        }

        if (strtoupper($value) === $value) {
            return true;
        }

        return false;
    }
}
