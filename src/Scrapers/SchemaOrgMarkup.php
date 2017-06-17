<?php

namespace RecipeScraper\Scrapers;

use RecipeScraper\Arr;
use RecipeScraper\Str;
use RecipeScraper\Interval;
use Symfony\Component\DomCrawler\Crawler;
use RecipeScraper\ExtractsDataFromCrawler;

class SchemaOrgMarkup implements ScraperInterface
{
    use ExtractsDataFromCrawler;

    /**
     * @var string[]
     */
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
        if (method_exists($this, 'preExtractionFilter')) {
            $crawler = $this->preExtractionFilter($crawler);
        }

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

            $recipe[$key] = $value ?: null;
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
        return $this->extractString(
            $crawler,
            '[itemtype="http://schema.org/Recipe"] [itemprop="author"]'
        );
    }

    protected function extractCategories(Crawler $crawler)
    {
        return $this->extractArray($crawler, '[itemprop="recipeCategory"]');
    }

    protected function extractCookingMethod(Crawler $crawler)
    {
        return $this->extractString(
            $crawler,
            '[itemtype="http://schema.org/Recipe"] [itemprop="cookingMethod"]'
        );
    }

    protected function extractCookTime(Crawler $crawler)
    {
        return $this->extractString(
            $crawler,
            '[itemprop="cookTime"]',
            ['datetime', 'content', '_text']
        );
    }

    protected function extractCuisines(Crawler $crawler)
    {
        return $this->extractArray($crawler, '[itemprop="recipeCuisine"]');
    }

    protected function extractDescription(Crawler $crawler)
    {
        return $this->extractString(
            $crawler,
            '[itemtype="http://schema.org/Recipe"] [itemprop="description"]'
        );
    }

    protected function extractImage(Crawler $crawler)
    {
        return $this->extractString(
            $crawler,
            '[itemtype="http://schema.org/Recipe"] [itemprop="image"]',
            ['src']
        );
    }

    protected function extractIngredients(Crawler $crawler)
    {
        return $this->extractArray(
            $crawler,
            '[itemprop="recipeIngredient"], [itemprop="ingredients"]'
        );
    }

    protected function extractInstructions(Crawler $crawler)
    {
        return $this->extractArray($crawler, '[itemprop="recipeInstructions"]');
    }

    protected function extractName(Crawler $crawler)
    {
        return $this->extractString(
            $crawler,
            '[itemtype="http://schema.org/Recipe"] [itemprop="name"]'
        );
    }

    protected function extractPrepTime(Crawler $crawler)
    {
        return $this->extractString(
            $crawler,
            '[itemprop="prepTime"]',
            ['datetime', 'content', '_text']
        );
    }

    protected function extractPublisher(Crawler $crawler)
    {
        return $this->extractString(
            $crawler,
            '[itemtype="http://schema.org/Recipe"] [itemprop="publisher"]'
        );
    }

    protected function extractTotalTime(Crawler $crawler)
    {
        return $this->extractString(
            $crawler,
            '[itemprop="totalTime"]',
            ['datetime', 'content', '_text']
        );
    }

    protected function extractUrl(Crawler $crawler)
    {
        return $this->extractString(
            $crawler,
            '[itemtype="http://schema.org/Recipe"] [itemprop="url"]',
            ['href']
        );
    }

    protected function extractYield(Crawler $crawler)
    {
        return $this->extractString($crawler, '[itemprop="recipeYield"]', ['content', '_text']);
    }

    protected function normalizeInterval($value)
    {
        if (! is_string($value)) {
            return $value;
        }

        return Interval::normalize($value) ?: null;
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
