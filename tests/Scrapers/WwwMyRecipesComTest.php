<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Scrapers\WwwMyRecipesCom;

class WwwMyRecipesComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'www.myrecipes.com';
    }

    protected function makeScraper()
    {
        return new WwwMyRecipesCom;
    }
}
