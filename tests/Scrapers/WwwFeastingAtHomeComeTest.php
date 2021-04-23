<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Scrapers\SchemaOrgJsonLd;

/**
 * @group scraper
 */
class WwwFeastingAtHomeComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'www.feastingathome.com';
    }

    protected function makeScraper()
    {
        return new SchemaOrgJsonLd;
    }
}
