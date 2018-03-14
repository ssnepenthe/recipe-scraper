<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Scrapers\HearstDigitalMedia;

/**
 * @group hearst
 * @group scraper
 */
class WwwDelishComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'www.delish.com';
    }

    protected function makeScraper()
    {
        return new HearstDigitalMedia;
    }
}
