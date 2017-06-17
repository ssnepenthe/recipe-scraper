<?php

namespace RecipeScraper\Scrapers;

use RecipeScraper\Extractors\ExtractorManager;

class ScraperFactory
{
    public static function make() : DelegatingScraper
    {
        $extractor = new ExtractorManager;
        $scraperClasses = [
            AllRecipesCom::class,
            CookieAndKateCom::class,
            EmerilsCom::class,
            FarmFlavorCom::class,
            GeneralMills::class,
            HearstDigitalMedia::class,
            ScrippsNetworks::class,
            SpryLivingCom::class,
            ThePioneerWomanCom::class,
            WwwBhgCom::class,
            WwwEpicuriousCom::class,
            WwwFoodAndWineCom::class,
            WwwFoodCom::class,
            WwwJustATasteCom::class,
            WwwMyRecipesCom::class,
            WwwPaulaDeenCom::class,
            WwwTasteOfHomeCom::class,

            // Fallbacks.
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
