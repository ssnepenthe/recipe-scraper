<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

use SSNepenthe\RecipeScraper\Arr;
use SSNepenthe\RecipeScraper\Str;
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

    protected $properties = [
        'author',
        'categories',
        'cookingMethod',
        'cookTime',
        'cuisines',
        'description',
        'image',
        'ingredients',
        'instructions',
        'name',
        'prepTime',
        'publisher',
        'totalTime',
        'url',
        'yield',
    ];

    public function scrape(Crawler $crawler) : array
    {
        $recipe = [];

        foreach ($this->properties as $key) {
            $methodKey = ucfirst($key);
            $extractor = "extract{$methodKey}";
            $preNormalizer = "preNormalize{$methodKey}";
            $postNormalizer = "postNormalize{$methodKey}";

            $value = $this->{$extractor}($crawler);

            if (method_exists($this, $preNormalizer)) {
                $value = $this->{$preNormalizer}($value);
            }

            if (is_array($value)) {
                $value = Arr::normalize($value);
            } elseif (is_string($value)) {
                $value = Str::normalize($value);
            }

            if (method_exists($this, $postNormalizer)) {
                $value = $this->{$postNormalizer}($value);
            }

            $recipe[$key] = $value;
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

    protected function normalizeInterval($value)
    {
        if (! is_string($value)) {
            return $value;
        }

        try {
            return Interval::toIso8601(Interval::fromString($value));
        } catch (\Exception $e) {
            return $value;
        }
    }

    protected function postNormalizeCookTime($value)
    {
        return $this->normalizeInterval($value);
    }

    protected function postNormalizePrepTime($value)
    {
        return $this->normalizeInterval($value);
    }

    protected function postNormalizeTotalTime($value)
    {
        return $this->normalizeInterval($value);
    }
}
