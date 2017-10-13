<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Scrapers\GeneralMills;

/**
 * @group gm
 */
class WwwTablespoonComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'www.tablespoon.com';
    }

    protected function makeScraper()
    {
        return new GeneralMills;
    }
}
