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
        Scrapers\AllRecipesCom::class => null,
        Scrapers\CookieAndKateCom::class => null,
        Scrapers\EmerilsCom::class => null,
        Scrapers\FarmFlavorCom::class => null,
        Scrapers\GeneralMills::class => null,
        Scrapers\HearstDigitalMedia::class => null,
        Scrapers\ScrippsNetworks::class => null,
        Scrapers\SpryLivingCom::class => null,
        Scrapers\ThePioneerWomanCom::class => null,
        Scrapers\WwwBhgCom::class => null,
        Scrapers\WwwEpicuriousCom::class => null,
        Scrapers\WwwFineCookingCom::class => null,
        Scrapers\WwwFoodAndWineCom::class => null,
        Scrapers\WwwFoodCom::class => null,
        Scrapers\WwwJustATasteCom::class => null,
        Scrapers\WwwMyRecipesCom::class => null,
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
            throw new \InvalidArgumentException;
        }

        if (isset(static::$scrapers[$class])) {
            return static::$scrapers[$class];
        }

        return static::$scrapers[$class] = new $class;
    }
}
