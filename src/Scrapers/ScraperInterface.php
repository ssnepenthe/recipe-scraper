<?php

namespace RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;

interface ScraperInterface
{
    public function scrape(Crawler $crawler) : array;
    public function supports(Crawler $crawler) : bool;
}
