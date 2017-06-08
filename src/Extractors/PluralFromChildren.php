<?php

namespace RecipeScraper\Extractors;

use Symfony\Component\DomCrawler\Crawler;

class PluralFromChildren implements ExtractorInterface
{
    public function extract(Crawler $crawler, $selector, $attr = '_text')
    {
        $nodes = $crawler->filter($selector);

        if (! $nodes->count()) {
            return null;
        }

        $values = $nodes->each(function (Crawler $node) use ($attr) {
            $childNodes = $node->children();

            if (! $childNodes->count()) {
                return trim('_text' === $attr ? $node->text() : $node->attr($attr));
            }

            $subValues = $node->children()->each(
                function (Crawler $subNode) use ($attr) {
                    return trim(
                        '_text' === $attr ? $subNode->text() : $subNode->attr($attr)
                    );
                }
            );

            return implode(' ', array_filter($subValues));
        });

        return $values;
    }
}
