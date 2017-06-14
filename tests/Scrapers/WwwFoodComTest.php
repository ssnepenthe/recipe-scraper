<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraper\Scrapers\WwwFoodCom;
use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Extractors\ExtractorManager;

class WwwFoodComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'www.food.com';
    }

    protected function makeScraper()
    {
        return new WwwFoodCom(new ExtractorManager);
    }
}
