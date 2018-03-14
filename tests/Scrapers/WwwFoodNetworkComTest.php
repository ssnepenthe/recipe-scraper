<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Scrapers\ScrippsNetworks;

/**
 * @group scraper
 * @group scripps
 */
class WwwFoodNetworkComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'www.foodnetwork.com';
    }

    protected function makeScraper()
    {
        return new ScrippsNetworks;
    }
}
