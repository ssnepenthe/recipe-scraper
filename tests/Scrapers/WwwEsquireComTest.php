<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Scrapers\HearstDigitalMedia;

/**
 * @group hearst
 * @group scraper
 */
class WwwEsquireComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'www.esquire.com';
    }

    protected function makeScraper()
    {
        return new HearstDigitalMedia;
    }
}
