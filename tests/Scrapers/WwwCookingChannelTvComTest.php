<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Scrapers\ScrippsNetworks;

/**
 * @group scraper
 * @group scripps
 */
class WwwCookingChannelTvComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'www.cookingchanneltv.com';
    }

    protected function makeScraper()
    {
        return new ScrippsNetworks;
    }
}
