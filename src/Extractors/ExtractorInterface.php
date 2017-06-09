<?php

namespace RecipeScraper\Extractors;

use Symfony\Component\DomCrawler\Crawler;

interface ExtractorInterface
{
    public function extract(Crawler $crawler, $selector, array $attrs = ['_text']);
}
