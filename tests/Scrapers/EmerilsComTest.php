<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraper\Scrapers\EmerilsCom;
use RecipeScraperTests\ScraperTestCase;

class EmerilsComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'emerils.com';
    }

    protected function makeScraper()
    {
        return new EmerilsCom;
    }
}
