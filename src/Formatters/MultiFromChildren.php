<?php

namespace SSNepenthe\RecipeScraper\Formatters;

use Symfony\Component\DomCrawler\Crawler;
use SSNepenthe\RecipeScraper\Interfaces\Formatter;

class MultiFromChildren implements Formatter {
    public function format(Crawler $crawler, array $config) {
        $locations = $config['locations'];

        $return = $crawler->each(function(Crawler $node, $i) use ($locations) {
            // Symfony dom-crawler methods ignore text nodes, so we have to
            // revert to native DOMNode methods instead.
            $children = $node->getNode(0)->childNodes;
            $values = [];

            foreach ($children as $child) {
                // Skip non element or text nodes.
                if (! in_array($child->nodeType, [1, 3])) {
                    continue;
                }

                // Loop through locations but stop after the first truthy value.
                foreach ($locations as $location) {
                    if (
                        '_text' === $location &&
                        $value = trim($child->nodeValue)
                    ) {
                        $values[] = $value;
                        continue 2;
                    }

                    // DOMText does not have method hasAttribute.
                    if (
                        1 === $child->nodeType &&
                        $child->hasAttribute($location) &&
                        $value = trim($child->getAttribute($location))
                    ) {
                        $values[] = $value;
                        continue 2;
                    }
                }
            }

            // Remove any lingering 'empty' elements.
            $values = array_filter(array_map('trim', $values));

            return implode(' ', $values);
        });

        return array_values(array_filter($return));
    }
}
