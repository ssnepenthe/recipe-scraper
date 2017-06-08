<?php

namespace RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;

interface ScraperResolverInterface
{
	public function resolve(Crawler $crawler);
}
