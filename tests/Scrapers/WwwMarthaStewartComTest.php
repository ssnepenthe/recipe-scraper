<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Scrapers\WwwMarthaStewartCom;

/**
 * @group scraper
 */
class WwwMarthaStewartComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'www.marthastewart.com';
    }

    protected function makeScraper()
    {
        return new WwwMarthaStewartCom;
    }
}
