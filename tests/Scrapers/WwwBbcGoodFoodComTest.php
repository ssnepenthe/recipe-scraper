<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Scrapers\SchemaOrgJsonLd;

/**
 * @group scraper
 */
class WwwBbcGoodFoodComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'www.bbcgoodfood.com';
    }

    protected function makeScraper()
    {
        return new SchemaOrgJsonLd;
    }
}
