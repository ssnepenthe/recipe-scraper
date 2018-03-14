<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraper\Scrapers\WwwBhgCom;
use RecipeScraperTests\ScraperTestCase;

/**
 * @todo Haven't been able to find recipes with ingredient groups.
 * @group scraper
 */
class WwwBhgComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'www.bhg.com';
    }

    protected function makeScraper()
    {
        return new WwwBhgCom;
    }
}
