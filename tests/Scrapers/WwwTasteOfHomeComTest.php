<?php

namespace RecipeScraperTests\Scrapers;

use RecipeScraperTests\ScraperTestCase;
use RecipeScraper\Scrapers\WwwTasteOfHomeCom;

class WwwTasteOfHomeComTest extends ScraperTestCase
{
	protected function getHost()
	{
    	return 'www.tasteofhome.com';
	}

	protected function makeScraper()
	{
		return new WwwTasteOfHomeCom;
	}
}
