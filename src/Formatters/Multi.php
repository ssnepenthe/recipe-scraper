<?php

namespace SSNepenthe\RecipeScraper\Formatters;

use Symfony\Component\DomCrawler\Crawler;
use SSNepenthe\RecipeScraper\Interfaces\Formatter;

class Multi implements Formatter
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

            if (in_array(
                $node->nodeName(),
                ['h1', 'h2', 'h3', 'h4', 'h5', 'h6']
            )) {
                $values = array_map(function($value) {
                    return '%%TITLE%%' . $value . '%%TITLE%%';
                }, $values);
            }

            return array_shift($values);
        });

        return array_values(array_filter($return));
    }
}
