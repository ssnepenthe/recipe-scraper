<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Scrapers\WwwTwoPeasAndTheirPodCom;

class WwwTwoPeasAndTheirPodComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'www.twopeasandtheirpod.com';
    }

    protected function makeScraper()
    {
        return new WwwTwoPeasAndTheirPodCom;
    }
}
