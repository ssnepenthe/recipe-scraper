<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Scrapers\WwwEpicuriousCom;
use RecipeScraper\Extractors\ExtractorManager;

class WwwEpicuriousComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'www.epicurious.com';
    }

    protected function makeScraper()
    {
        return new WwwEpicuriousCom(new ExtractorManager);
    }
}
