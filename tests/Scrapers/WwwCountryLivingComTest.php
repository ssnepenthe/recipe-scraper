<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Scrapers\HearstDigitalMedia;

/**
 * @group hearst
 * @group scraper
 */
class WwwCountryLivingComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'www.countryliving.com';
    }

    protected function makeScraper()
    {
        return new HearstDigitalMedia;
    }
}
