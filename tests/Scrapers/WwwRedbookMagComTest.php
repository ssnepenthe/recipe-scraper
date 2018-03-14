<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Scrapers\HearstDigitalMedia;

/**
 * @group hearst
 * @group scraper
 */
class WwwRedbookMagComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'www.redbookmag.com';
    }

    protected function makeScraper()
    {
        return new HearstDigitalMedia;
    }
}
