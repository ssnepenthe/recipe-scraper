<?php

namespace RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;

interface ScraperInterface
{
	/**
	 * @param  Crawler $crawler
	 * @return array
	 */
    public function scrape(Crawler $crawler) : array;

    /**
     * @param  Crawler $crawler
     * @return boolean
     */
    public function supports(Crawler $crawler) : bool;
}
