<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Scrapers\ScrippsNetworks;
use RecipeScraper\Extractors\ExtractorManager;

class WwwCookingChannelTvComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'www.cookingchanneltv.com';
    }

    protected function makeScraper()
    {
        return new ScrippsNetworks(new ExtractorManager);
    }
}
