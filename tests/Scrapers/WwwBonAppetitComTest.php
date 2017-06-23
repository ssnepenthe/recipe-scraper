<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Scrapers\WwwBonAppetitCom;

class WwwBonAppetitComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'www.bonappetit.com';
    }

    protected function makeScraper()
    {
        return new WwwBonAppetitCom;
    }
}
