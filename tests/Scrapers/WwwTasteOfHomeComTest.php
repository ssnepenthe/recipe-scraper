<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Scrapers\WwwTasteOfHomeCom;
use RecipeScraper\Extractors\ExtractorManager;

class WwwTasteOfHomeComTest extends ScraperTestCase
{
	protected function getHost()
	{
    	return 'www.tasteofhome.com';
	}

	protected function makeScraper()
	{
		return new WwwTasteOfHomeCom(new ExtractorManager);
	}
}
