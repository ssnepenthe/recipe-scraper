<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

use SSNepenthe\RecipeScraper\Interval;
use Symfony\Component\DomCrawler\Crawler;
use SSNepenthe\RecipeScraper\Extractors\PluralExtractor;
use SSNepenthe\RecipeScraper\Extractors\SingularExtractor;
use SSNepenthe\RecipeScraper\Extractors\PluralFromChildren;

class SchemaOrgMarkup implements ScraperInterface
{
    const SINGULAR_EXTRACTOR = SingularExtractor::class;
    const PLURAL_EXTRACTOR = PluralExtractor::class;
    const PLURAL_CHILDREN_EXTRACTOR = PluralFromChildren::class;

    protected $extractors = [
        PluralExtractor::class => null,
        SingularExtractor::class => null,
        PluralFromChildren::class => null,
    ];

    public function scrape(Crawler $crawler) : array
    {
        $intervals = ['cookTime', 'prepTime', 'totalTime'];
        $misc = [
            'author',
            'categories',
            'cookingMethod',
            'cuisines',
            'description',
            'image',
            'ingredients',
            'instructions',
            'name',
            'publisher',
            'url',
            'yield',
        ];
        $recipe = [];

        foreach (array_merge($intervals, $misc) as $key) {
            $method = 'extract' . ucfirst($key);

            $recipe[$key] = $this->{$method}($crawler);
        }

        foreach ($intervals as $key) {
            try {
                $interval = Interval::toIso8601(
                    Interval::fromString($recipe[$key])
                );
            } catch (\Exception $e) {
                $interval = $recipe[$key];
            }

            $recipe[$key] = $interval;
        }

        return $recipe;
    }

    public function supports(Crawler $crawler) : bool
    {
        return (bool) $crawler
            ->filter('[itemtype="http://schema.org/Recipe"]')
            ->count();
    }

    protected function extractAuthor(Crawler $crawler)
    {
        return $this->makeExtractor(self::SINGULAR_EXTRACTOR)
            ->extract(
                $crawler,
                '[itemtype="http://schema.org/Recipe"] [itemprop="author"]'
            );
    }

    protected function extractCategories(Crawler $crawler)
    {
        return $this->makeExtractor(self::PLURAL_EXTRACTOR)
            ->extract($crawler, '[itemprop="recipeCategory"]');
    }

    protected function extractCookingMethod(Crawler $crawler)
    {
        return $this->makeExtractor(self::SINGULAR_EXTRACTOR)
            ->extract(
                $crawler,
                '[itemtype="http://schema.org/Recipe"] [itemprop="cookingMethod"]'
            );
    }

    protected function extractCookTime(Crawler $crawler)
    {
        return $this->makeExtractor(self::SINGULAR_EXTRACTOR)
            ->extract($crawler, '[itemprop="cookTime"]', 'datetime');
    }

    protected function extractCuisines(Crawler $crawler)
    {
        return $this->makeExtractor(self::PLURAL_EXTRACTOR)
            ->extract($crawler, '[itemprop="recipeCuisine"]');
    }

    protected function extractDescription(Crawler $crawler)
    {
        return $this->makeExtractor(self::SINGULAR_EXTRACTOR)
            ->extract(
                $crawler,
                '[itemtype="http://schema.org/Recipe"] [itemprop="description"]'
            );
    }

    protected function extractImage(Crawler $crawler)
    {
        return $this->makeExtractor(self::SINGULAR_EXTRACTOR)
            ->extract(
                $crawler,
                '[itemtype="http://schema.org/Recipe"] [itemprop="image"]',
                'src'
            );
    }

    protected function extractIngredients(Crawler $crawler)
    {
        return $this->makeExtractor(self::PLURAL_EXTRACTOR)
            ->extract($crawler, '[itemprop="recipeIngredient"]');
    }

    protected function extractInstructions(Crawler $crawler)
    {
        return $this->makeExtractor(self::PLURAL_EXTRACTOR)
            ->extract($crawler, '[itemprop="recipeInstructions"]');
    }

    protected function extractName(Crawler $crawler)
    {
        return $this->makeExtractor(self::SINGULAR_EXTRACTOR)
            ->extract(
                $crawler,
                '[itemtype="http://schema.org/Recipe"] [itemprop="name"]'
            );
    }

    protected function extractPrepTime(Crawler $crawler)
    {
        return $this->makeExtractor(self::SINGULAR_EXTRACTOR)
            ->extract($crawler, '[itemprop="prepTime"]', 'datetime');
    }

    protected function extractPublisher(Crawler $crawler)
    {
        return $this->makeExtractor(self::SINGULAR_EXTRACTOR)
            ->extract(
                $crawler,
                '[itemtype="http://schema.org/Recipe"] [itemprop="publisher"]'
            );
    }

    protected function extractTotalTime(Crawler $crawler)
    {
        return $this->makeExtractor(self::SINGULAR_EXTRACTOR)
            ->extract($crawler, '[itemprop="totalTime"]', 'datetime');
    }

    protected function extractUrl(Crawler $crawler)
    {
        return $this->makeExtractor(self::SINGULAR_EXTRACTOR)
            ->extract(
                $crawler,
                '[itemtype="http://schema.org/Recipe"] [itemprop="url"]',
                'href'
            );
    }

    protected function extractYield(Crawler $crawler)
    {
        return $this->makeExtractor(self::SINGULAR_EXTRACTOR)
            ->extract($crawler, '[itemprop="recipeYield"]', 'content');
    }

    protected function makeExtractor($type)
    {
        if (! array_key_exists($type, $this->extractors)) {
            throw new \InvalidArgumentException;
        }

        if (! is_null($this->extractors[$type])) {
            return $this->extractors[$type];
        }

        return $this->extractors[$type] = new $type;
    }
}
