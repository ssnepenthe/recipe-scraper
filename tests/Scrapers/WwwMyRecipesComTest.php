<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Scrapers\WwwMyRecipesCom;
use RecipeScraper\Extractors\ExtractorManager;

class WwwMyRecipesComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'www.myrecipes.com';
    }

    protected function makeScraper()
    {
        return new WwwMyRecipesCom(new ExtractorManager);
    }
}
