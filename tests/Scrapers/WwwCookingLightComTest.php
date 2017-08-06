<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraper\Scrapers\TimeInc;
use RecipeScraperTests\ScraperTestCase;

class WwwCookingLightComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'www.cookinglight.com';
    }

    protected function makeScraper()
    {
        return new TimeInc;
    }
}
