<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Scrapers\HearstDigitalMedia;

/**
 * @group hearst
 * @group scraper
 */
class WwwWomansDayComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'www.womansday.com';
    }

    protected function makeScraper()
    {
        return new HearstDigitalMedia;
    }
}
