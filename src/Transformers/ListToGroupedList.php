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

            // Remove colon and title token.
            $title = str_replace(
                ['%%TITLE%%', ':'],
                '',
                $values[ $position ]
            );
            // Remove characters intended to indicate this is a header.
            $title = preg_replace('/[#\*\-_=\+]{2,}/', '', $title);
            // Remove leading digits.
            $title = preg_replace('/\d+\.?\s+/', '', $title);
            // Finally trim whitespace and capitalize first letter of words.
            $title = ucwords(strtolower(trim($title)));

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
        if (false !== strpos($value, '%%TITLE%%')) {
            return true;
        }

        if (':' === substr($value, -1)) {
            return true;
        }

        if (strtoupper($value) === $value) {
            return true;
        }

        if (preg_match('/[#\*\-_=\+]{2,}/', $value)) {
            return true;
        }

        return false;
    }
}
