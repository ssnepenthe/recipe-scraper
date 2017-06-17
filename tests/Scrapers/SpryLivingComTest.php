<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Scrapers\SpryLivingCom;

class SpryLivingComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'spryliving.com';
    }

    protected function makeScraper()
    {
        return new SpryLivingCom;
    }
}
