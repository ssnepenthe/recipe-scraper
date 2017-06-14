<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraper\Scrapers\WwwBhgCom;
use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Extractors\ExtractorManager;

/**
 * @todo Haven't been able to find recipes with ingredient groups.
 */
class WwwBhgComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'www.bhg.com';
    }

    protected function makeScraper()
    {
        return new WwwBhgCom(new ExtractorManager);
    }
}
