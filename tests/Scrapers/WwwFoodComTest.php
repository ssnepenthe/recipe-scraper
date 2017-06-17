<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraper\Scrapers\WwwFoodCom;
use RecipeScraperTests\ScraperTestCase;

class WwwFoodComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'www.food.com';
    }

    protected function makeScraper()
    {
        return new WwwFoodCom;
    }
}
