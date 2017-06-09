<?php

namespace RecipeScraper\Extractors;

use Symfony\Component\DomCrawler\Crawler;

class Singular implements ExtractorInterface
{
    public function extract(Crawler $crawler, $selector, array $attrs = ['_text'])
    {
        $nodes = $crawler->filter($selector);

        if (! $nodes->count()) {
        	return null;
        }

        foreach ($attrs as $attr) {
        	if ('_text' === $attr && $value = trim($nodes->text())) {
        		return $value;
        	}

        	if ($value = trim($nodes->attr($attr))) {
        		return $value;
        	}
        }

        return null;
    }
}
