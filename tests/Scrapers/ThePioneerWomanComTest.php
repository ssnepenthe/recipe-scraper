<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Scrapers\ThePioneerWomanCom;

/**
 * @group scraper
 */
class ThePioneerWomanComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'thepioneerwoman.com';
    }

    protected function makeScraper()
    {
        return new ThePioneerWomanCom;
    }
}
