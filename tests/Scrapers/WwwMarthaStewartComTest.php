<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Scrapers\SchemaOrgJsonLd;
use RecipeScraper\Extractors\ExtractorManager;

class WwwMarthaStewartComTest extends ScraperTestCase
{
    protected function getHost()
    {
        return 'www.marthastewart.com';
    }

    protected function makeScraper()
    {
        return new SchemaOrgJsonLd(new ExtractorManager);
    }
}
