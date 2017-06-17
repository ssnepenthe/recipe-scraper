<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Scrapers\WwwPaulaDeenCom;

class WwwPaulaDeenComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'www.pauladeen.com';
    }

    protected function makeScraper()
    {
        return new WwwPaulaDeenCom;
    }
}
