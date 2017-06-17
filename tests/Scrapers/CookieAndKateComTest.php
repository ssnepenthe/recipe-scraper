<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Scrapers\CookieAndKateCom;

class CookieAndKateComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'cookieandkate.com';
    }

    protected function makeScraper()
    {
        return new CookieAndKateCom;
    }
}
