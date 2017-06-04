<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

use SSNepenthe\RecipeScraper\Arr;
use SSNepenthe\RecipeScraper\Str;
use SSNepenthe\RecipeScraper\Interval;
use Symfony\Component\DomCrawler\Crawler;

class SchemaOrgJsonLd implements ScraperInterface
{
    const SELECTOR = 'script[type="application/ld+json"]';

    protected $intervals = ['cookTime', 'prepTime', 'totalTime'];
    protected $properties = [
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

    public function scrape(Crawler $crawler) : array
    {
        $json = $this->getJson($crawler);
        $recipe = [];

        foreach (array_merge($this->intervals, $this->properties) as $key) {
            $method = 'extract' . ucfirst($key);

            // Only difference between this and SchemaOrgMarkup...
            $value = $this->{$method}($crawler, $json);

            if (is_array($value)) {
                $value = Arr::normalize($value);
            } else {
                $value = Str::normalize($value);
            }

            $recipe[$key] = $value;
        }

        foreach ($this->intervals as $key) {
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
        return ! empty($this->getJson($crawler));
    }

    protected function extractAuthor(Crawler $crawler, array $json)
    {
        if (is_string($author = Arr::get($json, 'author.name'))) {
            return $author;
        }

        if (is_string($author = Arr::get($json, 'author'))) {
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

        if (is_string($image = Arr::get($json, 'image'))) {
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

        if (is_string($publisher = Arr::get($json, 'publisher'))) {
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
                || 'http://schema.org' !== Arr::get($json, '@context')
                || 'Recipe' !== Arr::get($json, '@type')
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
}
