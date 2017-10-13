<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Scrapers\HearstDigitalMedia;

/**
 * @group hearst
 */
class WwwGoodHousekeepingComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'www.goodhousekeeping.com';
    }

    protected function makeScraper()
    {
        return new HearstDigitalMedia;
    }
}
