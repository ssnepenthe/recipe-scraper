<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Scrapers\WwwJamieOliverCom;

/**
 * @group scraper
 */
class WwwJamieOliverComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'www.jamieoliver.com';
    }

    protected function makeScraper()
    {
        return new WwwJamieOliverCom;
    }
}
