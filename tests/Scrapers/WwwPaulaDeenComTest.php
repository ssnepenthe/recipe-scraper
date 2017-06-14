<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Scrapers\WwwPaulaDeenCom;
use RecipeScraper\Extractors\ExtractorManager;

class WwwPaulaDeenComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'www.pauladeen.com';
    }

    protected function makeScraper()
    {
        return new WwwPaulaDeenCom(new ExtractorManager);
    }
}
