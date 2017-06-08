<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

use SSNepenthe\RecipeScraper\Arr;
use SSNepenthe\RecipeScraper\Str;
use SSNepenthe\RecipeScraper\Interval;
use Symfony\Component\DomCrawler\Crawler;
use SSNepenthe\RecipeScraper\Extractors\ExtractorManager;

/**
 * Supports marthastewart.com.
 *     * Occasionally includes links to other recipes in ingredients section
 *     * Has keywords available which could potentially be used as extra categories.
 */
class SchemaOrgJsonLd implements ScraperInterface
{
    protected $extractor;
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

    public function __construct(ExtractorManager $extractor)
    {
        $this->extractor = $extractor;
    }

    public function scrape(Crawler $crawler) : array
    {
        $json = $this->getJson($crawler);
        $recipe = [];

        foreach ($this->properties as $key) {
            $methodKey = ucfirst($key);
            $extractor = "extract{$methodKey}";
            $preNormalizer = "preNormalize{$methodKey}";
            $postNormalizer = "postNormalize{$methodKey}";

            $value = $this->{$extractor}($crawler, $json);

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
        return ! empty($this->getJson($crawler));
    }

    protected function extractAuthor(Crawler $crawler, array $json)
    {
        if (is_string($author = Arr::get($json, 'author.name'))) {
            return $author;
        }

        // Normalizer can sort out the type.
        if (! is_null($author = Arr::get($json, 'author'))) {
            return $author;
        }

        return null;
    }

    protected function extractCategories(Crawler $crawler, array $json)
    {
        if (is_array($categories = Arr::get($json, 'recipeCategory'))) {
            return $categories;
        }

        return null;
    }

    protected function extractCookingMethod(Crawler $crawler, array $json)
    {
        if (is_string($cookingMethod = Arr::get($json, 'cookingMethod'))) {
            return $cookingMethod;
        }

        return null;
    }

    protected function extractCookTime(Crawler $crawler, array $json)
    {
        if (is_string($cookTime = Arr::get($json, 'cookTime'))) {
            return $cookTime;
        }

        return null;
    }

    protected function extractCuisines(Crawler $crawler, array $json)
    {
        if (is_array($cuisines = Arr::get($json, 'recipeCuisine'))) {
            return $cuisines;
        }

        return null;
    }

    protected function extractDescription(Crawler $crawler, array $json)
    {
        if (is_string($description = Arr::get($json, 'description'))) {
            return $description;
        }

        return null;
    }

    protected function extractImage(Crawler $crawler, array $json)
    {
        if (is_string($image = Arr::get($json, 'image.url'))) {
            return $image;
        }

        if (! is_null($image = Arr::get($json, 'image'))) {
            return $image;
        }

        return null;
    }

    protected function extractIngredients(Crawler $crawler, array $json)
    {
        if (is_array($ingredients = Arr::get($json, 'recipeIngredient'))) {
            return $ingredients;
        }

        if (is_array($ingredients = Arr::get($json, 'ingredients'))) {
            return $ingredients;
        }

        return null;
    }

    protected function extractInstructions(Crawler $crawler, array $json)
    {
        if (is_array($instructions = Arr::get($json, 'recipeInstructions'))) {
            return $instructions;
        }

        return null;
    }

    protected function extractName(Crawler $crawler, array $json)
    {
        if (is_string($name = Arr::get($json, 'name'))) {
            return $name;
        }

        return null;
    }

    protected function extractPrepTime(Crawler $crawler, array $json)
    {
        if (is_string($prepTime = Arr::get($json, 'prepTime'))) {
            return $prepTime;
        }

        return null;
    }

    protected function extractPublisher(Crawler $crawler, array $json)
    {
        if (is_string($publisher = Arr::get($json, 'publisher.name'))) {
            return $publisher;
        }

        // Normalizer can sort out the type.
        if (! is_null($publisher = Arr::get($json, 'publisher'))) {
            return $publisher;
        }

        return null;
    }

    protected function extractTotalTime(Crawler $crawler, array $json)
    {
        if (is_string($totalTime = Arr::get($json, 'totalTime'))) {
            return $totalTime;
        }

        return null;
    }

    protected function extractUrl(Crawler $crawler, array $json)
    {
        if (is_string($url = Arr::get($json, 'url'))) {
            return $url;
        }

        return null;
    }

    protected function extractYield(Crawler $crawler, array $json)
    {
        if (is_string($yield = Arr::get($json, 'recipeYield'))) {
            return $yield;
        }

        return null;
    }

    protected function getJson(Crawler $crawler)
    {
        $nodes = $crawler->filter('script[type="application/ld+json"]');

        if (! $nodes->count()) {
            return [];
        }

        $recipes = array_filter($nodes->each(function(Crawler $node) {
            $json = json_decode($node->text(), true);

            if (
                is_null($json)
                || JSON_ERROR_NONE !== json_last_error()
                || ! $this->hasSchemaOrgContext($json)
                || ! $this->hasRecipeType($json)
            ) {
                return false;
            }

            return $json;
        }));

        if (! count($recipes)) {
            return [];
        }

        return array_shift($recipes);
    }

    protected function hasRecipeType($json)
    {
        return 'Recipe' === Arr::get($json, '@type');
    }

    protected function hasSchemaOrgContext($json)
    {
        // Should always be an exact match 'http://schema.org' but that doesn't seem
        // to be the case in the wild so we'll do a more lenient pattern match.
        return (bool) preg_match(
            '/https?:\/\/(?:w{3}\.)?schema\.org/',
            Arr::get($json, '@context')
        );
    }

    protected function normalizeInterval($value)
    {
        if (! is_string($value)) {
            return $value;
        }

        try {
            return Interval::toIso8601(Interval::fromString($value));
        } catch (\Exception $e) {
            // Invalid or empty interval...
            return null;
        }
    }

    protected function normalizeObject($value, $property)
    {
        if (! is_array($value)) {
            return $value;
        }

        while (is_array($value)) {
            if (isset($value[$property])) {
                return $value[$property];
            }

            $value = array_shift($value);
        }

        return null;
    }

    protected function postNormalizeCookTime($value)
    {
        return $this->normalizeInterval($value);
    }

    protected function preNormalizeImage($value)
    {
        return $this->normalizeObject($value, 'url');
    }

    protected function postNormalizePrepTime($value)
    {
        return $this->normalizeInterval($value);
    }

    protected function postNormalizeTotalTime($value)
    {
        return $this->normalizeInterval($value);
    }

    protected function preNormalizeAuthor($value)
    {
        return $this->normalizeObject($value, 'name');
    }

    protected function preNormalizePublisher($value)
    {
        return $this->normalizeObject($value, 'name');
    }
}
