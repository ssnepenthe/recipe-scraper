<?php

namespace SSNepenthe\RecipeScraper\Formatters;

use Symfony\Component\DomCrawler\Crawler;

class Multi extends Base
{
    public function format(Crawler $crawler, array $config)
    {
        $locations = $config['locations'];

        $return = $crawler->each(function (Crawler $node, $i) use ($locations) {
            $values = $node->extract($locations);

            /**
             * Remove falsey values and normalize result...
             *
             * If 1 == count($locations), $values will contain strings,
             * otherwise $values will contain arrays.
             */
            if (is_array($values[0])) {
                $values = array_filter($values[0]);
            }

            if ($this->looksLikeGroupTitle($node)) {
                $values = array_map(function($value) {
                    return '%%TITLE%%' . $value . '%%TITLE%%';
                }, $values);
            }

            return array_shift($values);
        });

        return array_values(array_filter($return));
    }
}
