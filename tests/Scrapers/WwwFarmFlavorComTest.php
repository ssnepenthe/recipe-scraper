<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Scrapers\WwwFarmFlavorCom;

class FarmFlavorComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'www.farmflavor.com';
    }

    protected function makeScraper()
    {
        return new WwwFarmFlavorCom;
    }
}
