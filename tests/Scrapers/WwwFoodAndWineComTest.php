<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Scrapers\WwwFoodAndWineCom;
use RecipeScraper\Extractors\ExtractorManager;

class WwwFoodAndWineComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'www.foodandwine.com';
    }

    protected function makeScraper()
    {
        return new WwwFoodAndWineCom(new ExtractorManager);
    }
}
