<?php

namespace RecipeScraper\Scrapers;

use RecipeScraper\Extractors\ExtractorManager;

class ScraperFactory
{
	public static function make()
	{
		$extractor = new ExtractorManager;
		$scraperClasses = [
			AllRecipesCom::class,
			GeneralMills::class,
			ScrippsNetworks::class,
			SpryLivingCom::class,
			ThePioneerWomanCom::class,
			WwwBhgCom::class,
			WwwDelishCom::class,
			WwwEpicuriousCom::class,
			WwwFoodAndWineCom::class,
			WwwJustATasteCom::class,
			WwwMyRecipesCom::class,
			WwwPaulaDeenCom::class,
			WwwTasteOfHomeCom::class,
			SchemaOrgJsonLd::class,
			SchemaOrgMarkup::class,
		];
		$scrapers = [];

		foreach ($scraperClasses as $scraperClass) {
			$scrapers[] = new $scraperClass($extractor);
		}

		return new DelegatingScraper(new ScraperResolver($scrapers));
	}
}
