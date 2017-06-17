<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Scrapers\FarmFlavorCom;

class FarmFlavorComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'farmflavor.com';
    }

    protected function makeScraper()
    {
        return new FarmFlavorCom;
    }
}
