<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Scrapers\WwwJustATasteCom;

/**
 * @group scraper
 */
class WwwJustATasteComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'www.justataste.com';
    }

    protected function makeScraper()
    {
        return new WwwJustATasteCom;
    }
}
