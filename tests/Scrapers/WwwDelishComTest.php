<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Scrapers\WwwDelishCom;
use RecipeScraper\Extractors\ExtractorManager;

class WwwDelishComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'www.delish.com';
    }

    protected function makeScraper()
    {
        return new WwwDelishCom(new ExtractorManager);
    }
}
