<?php

namespace RecipeScraper\Extractors;

use Symfony\Component\DomCrawler\Crawler;

class Plural implements ExtractorInterface
{
    public function extract(Crawler $crawler, $selector, array $attrs = ['_text'])
    {
        $nodes = $crawler->filter($selector);

        if (! $nodes->count()) {
            return null;
        }

        $values = array_filter($nodes->each(function (Crawler $node) use ($attrs) {
            foreach ($attrs as $attr) {
                if ('_text' === $attr && $value = trim($node->text())) {
                    return $value;
                }

                if ($value = trim($node->attr($attr))) {
                    return $value;
                }
            }

            return null;
        }));

        return count($values) ? array_values($values) : null;
    }
}
