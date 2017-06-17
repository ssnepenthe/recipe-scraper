<?php

namespace RecipeScraper\Scrapers;

use RecipeScraper\Extractors\ExtractorManager;

class ScraperFactory
{
    protected static $delegatingScraper = null;
    protected static $extractor = null;
    protected static $scrapers = [
        AllRecipesCom::class => null,
        CookieAndKateCom::class => null,
        EmerilsCom::class => null,
        FarmFlavorCom::class => null,
        GeneralMills::class => null,
        HearstDigitalMedia::class => null,
        ScrippsNetworks::class => null,
        SpryLivingCom::class => null,
        ThePioneerWomanCom::class => null,
        WwwBhgCom::class => null,
        WwwEpicuriousCom::class => null,
        WwwFoodAndWineCom::class => null,
        WwwFoodCom::class => null,
        WwwJustATasteCom::class => null,
        WwwMyRecipesCom::class => null,
        WwwPaulaDeenCom::class => null,
        WwwTasteOfHomeCom::class => null,

        // Fallbacks.
        SchemaOrgJsonLd::class => null,
        SchemaOrgMarkup::class => null,
    ];

    public static function make(string $class = null) : ScraperInterface
    {
        if (! is_null($class)) {
            return static::makeScraperInstance($class);
        }

        return static::makeDelegatingScraperInstance();
    }

    protected static function makeDelegatingScraperInstance() : ScraperInterface
    {
        if (! is_null(static::$delegatingScraper)) {
            return static::$delegatingScraper;
        }

        $resolver = new ScraperResolver;

        foreach (array_keys(static::$scrapers) as $scraperClass) {
            $resolver->add(static::makeScraperInstance($scraperClass));
        }

        return static::$delegatingScraper = new DelegatingScraper($resolver);
    }

    protected static function makeExtractor() : ExtractorManager
    {
        if (! is_null(static::$extractor)) {
            return static::$extractor;
        }

        return static::$extractor = new ExtractorManager;
    }

    protected static function makeScraperInstance(string $class) : ScraperInterface
    {
        if (! array_key_exists($class, static::$scrapers)) {
            throw new \InvalidArgumentException;
        }

        if (isset(static::$scrapers[$class])) {
            return static::$scrapers[$class];
        }

        return static::$scrapers[$class] = new $class(static::makeExtractor());
    }
}
