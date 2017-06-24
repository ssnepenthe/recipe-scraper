<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Scrapers\WwwEatingWellCom;

class WwwEatingWellComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'www.eatingwell.com';
    }

    protected function makeScraper()
    {
        return new WwwEatingWellCom;
    }
}
