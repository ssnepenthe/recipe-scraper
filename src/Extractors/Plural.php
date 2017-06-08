<?php

namespace RecipeScraper\Extractors;

use Symfony\Component\DomCrawler\Crawler;

class Plural implements ExtractorInterface
{
    public function extract(Crawler $crawler, $selector, $attr = '_text')
    {
        $nodes = $crawler->filter($selector);

        return $nodes->count()
            ? $nodes->each(function (Crawler $node) use ($attr) {
                return trim('_text' === $attr ? $node->text() : $node->attr($attr));
            })
            // @todo Empty array?
            : null;
    }
}
