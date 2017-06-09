<?php

namespace RecipeScraper\Extractors;

use Symfony\Component\DomCrawler\Crawler;

class PluralFromChildren implements ExtractorInterface
{
    public function extract(Crawler $crawler, $selector, array $attrs = ['_text'])
    {
        $nodes = $crawler->filter($selector);

        if (! $nodes->count()) {
            return null;
        }

        $values = array_filter($nodes->each(function (Crawler $node) use ($attrs) {
            $childNodes = $node->children();

            if (! $childNodes->count()) {
                foreach ($attrs as $attr) {
                    if ('_text' === $attr && $value = trim($node->text())) {
                        return $value;
                    }

                    if ($value = trim($node->attr($attr))) {
                        return $value;
                    }
                }

                return null;
            }

            $subValues = $childNodes->each(function (Crawler $subNode) use ($attrs) {
                foreach ($attrs as $attr) {
                    if ('_text' === $attr && $value = trim($subNode->text())) {
                        return $value;
                    }

                    if ($value = trim($subNode->attr($attr))) {
                        return $value;
                    }
                }

                return null;
            });

            return implode(' ', array_filter($subValues));
        }));

        return count($values) ? array_values($values) : null;
    }
}
