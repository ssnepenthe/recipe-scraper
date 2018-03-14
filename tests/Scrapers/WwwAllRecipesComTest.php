<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Scrapers\WwwAllRecipesCom;

/**
 * @group scraper
 */
class WwwAllRecipesComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'www.allrecipes.com';
    }

    protected function makeScraper()
    {
        return new WwwAllRecipesCom;
    }
}
