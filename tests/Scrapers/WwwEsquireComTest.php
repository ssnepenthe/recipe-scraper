<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Extractors\ExtractorManager;
use RecipeScraper\Scrapers\HearstDigitalMedia;

class WwwEsquireComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'www.esquire.com';
    }

    protected function makeScraper()
    {
        return new HearstDigitalMedia(new ExtractorManager);
    }
}
