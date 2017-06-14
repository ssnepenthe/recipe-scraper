<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Scrapers\AllRecipesCom;
use RecipeScraper\Extractors\ExtractorManager;

class AllRecipesComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'allrecipes.com';
    }

    protected function makeScraper()
    {
        return new AllRecipesCom(new ExtractorManager);
    }
}
