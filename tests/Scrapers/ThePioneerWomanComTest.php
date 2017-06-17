<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Scrapers\ThePioneerWomanCom;

class ThePioneerWomanComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'thepioneerwoman.com';
    }

    protected function makeScraper()
    {
        return new ThePioneerWomanCom;
    }
}
