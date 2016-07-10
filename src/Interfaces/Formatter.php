<?php

namespace SSNepenthe\RecipeScraper\Interfaces;

use Symfony\Component\DomCrawler\Crawler;

interface Formatter {
	public function format(Crawler $crawler, array $config);
}
