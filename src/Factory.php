<?php

namespace RecipeScraper;

class Factory
{
    /**
     * @var Scrapers\DelegatingScraper|null
     */
    protected static $delegatingScraper = null;

    /**
     * @var array<string, Scrapers\ScraperInterface|null>
     */
    protected static $scrapers = [
        Scrapers\CookieAndKateCom::class => null,
        Scrapers\EmerilsCom::class => null,
        Scrapers\GeneralMills::class => null,
        Scrapers\HearstDigitalMedia::class => null,
        Scrapers\RecipesSparkPeopleCom::class => null,
        Scrapers\ScrippsNetworks::class => null,
        Scrapers\SpryLivingCom::class => null,
        Scrapers\ThePioneerWomanCom::class => null,
        Scrapers\TimeInc::class => null,
        Scrapers\WwwAllRecipesCom::class => null,
        Scrapers\WwwBhgCom::class => null,
        Scrapers\WwwBonAppetitCom::class => null,
        Scrapers\WwwEatingWellCom::class => null,
        Scrapers\WwwEpicuriousCom::class => null,
        Scrapers\WwwFarmFlavorCom::class => null,
        Scrapers\WwwFineCookingCom::class => null,
        Scrapers\WwwGeniusKitchenCom::class => null,
        Scrapers\WwwJamieOliverCom::class => null,
        Scrapers\WwwJustATasteCom::class => null,
        Scrapers\WwwMarthaStewartCom::class => null,
        Scrapers\WwwPaulaDeenCom::class => null,
        Scrapers\WwwTasteOfHomeCom::class => null,
        Scrapers\WwwTwoPeasAndTheirPodCom::class => null,

        // Fallbacks.
        Scrapers\SchemaOrgJsonLd::class => null,
        Scrapers\SchemaOrgMarkup::class => null,
    ];

    public static function make(string $class = null) : Scrapers\ScraperInterface
    {
        if (! is_null($class)) {
            return static::makeScraperInstance($class);
        }

        return static::makeDelegatingScraperInstance();
    }

    protected static function makeDelegatingScraperInstance() : Scrapers\ScraperInterface
    {
        if (! is_null(static::$delegatingScraper)) {
            return static::$delegatingScraper;
        }

        $resolver = new Scrapers\ScraperResolver;

        foreach (array_keys(static::$scrapers) as $scraperClass) {
            $resolver->add(static::makeScraperInstance($scraperClass));
        }

        return static::$delegatingScraper = new Scrapers\DelegatingScraper($resolver);
    }

    protected static function makeScraperInstance(string $class) : Scrapers\ScraperInterface
    {
        if (! array_key_exists($class, static::$scrapers)) {
            throw new \InvalidArgumentException("Scraper class {$class} not supported");
        }

        if (null === static::$scrapers[$class]) {
            static::$scrapers[$class] = new $class;
        }

        return static::$scrapers[$class];
    }
}
