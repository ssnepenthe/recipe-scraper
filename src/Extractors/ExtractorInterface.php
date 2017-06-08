<?php

namespace SSNepenthe\RecipeScraper\Extractors;

use Symfony\Component\DomCrawler\Crawler;

interface ExtractorInterface
{
	public function extract(Crawler $crawler, $selector, $attr = '_text');
}
