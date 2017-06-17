<?php

namespace RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;

interface ScraperResolverInterface
{
	/**
	 * @param  Crawler $crawler
	 * @return ScraperInterface|false
	 */
    public function resolve(Crawler $crawler);
}
