<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraper\Scrapers\TimeInc;
use RecipeScraperTests\ScraperTestCase;

/**
 * @group time
 */
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
