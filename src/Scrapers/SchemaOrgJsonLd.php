<?php

namespace RecipeScraper\Scrapers;

use RecipeScraper\Arr;
use RecipeScraper\Str;
use RecipeScraper\Interval;
use Symfony\Component\DomCrawler\Crawler;

class SchemaOrgJsonLd implements ScraperInterface
{
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
        'notes',
        'prepTime',
        'publisher',
        'totalTime',
        'url',
        'yield',
    ];

    /**
     * @param  Crawler $crawler
     * @return array
     */
    public function scrape(Crawler $crawler) : array
    {
        if (method_exists($this, 'preExtractionFilter')) {
            $crawler = $this->preExtractionFilter($crawler);
        }

        $json = $this->getJson($crawler);
        $recipe = [];

        foreach ($this->properties as $key) {
            $methodKey = ucfirst($key);
            $extractor = "extract{$methodKey}";
            $preNormalizer = "preNormalize{$methodKey}";
            $postNormalizer = "postNormalize{$methodKey}";

            $value = $this->{$extractor}($crawler, $json);

            if (method_exists($this, $preNormalizer)) {
                $value = $this->{$preNormalizer}($value, $crawler);
            }

            if (is_array($value)) {
                $value = Arr::normalize($value);
            } elseif (is_string($value)) {
                $value = Str::normalize($value);
            }

            if (method_exists($this, $postNormalizer)) {
                $value = $this->{$postNormalizer}($value, $crawler);
            }

            $recipe[$key] = $value ?: null;
        }

        return $recipe;
    }

    /**
     * @param  Crawler $crawler
     * @return boolean
     */
    public function supports(Crawler $crawler) : bool
    {
        return ! empty($this->getJson($crawler));
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string|null
     */
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

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string[]|null
     */
    protected function extractCategories(Crawler $crawler, array $json)
    {
        if (Arr::ofStrings($categories = Arr::get($json, 'recipeCategory'))) {
            return $categories;
        }

        if (is_string($categories)) {
            return [$categories];
        }

        return null;
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string|null
     */
    protected function extractCookingMethod(Crawler $crawler, array $json)
    {
        if (is_string($cookingMethod = Arr::get($json, 'cookingMethod'))) {
            return $cookingMethod;
        }

        return null;
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string|null
     */
    protected function extractCookTime(Crawler $crawler, array $json)
    {
        if (is_string($cookTime = Arr::get($json, 'cookTime'))) {
            return $cookTime;
        }

        return null;
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string[]|null
     */
    protected function extractCuisines(Crawler $crawler, array $json)
    {
        if (Arr::ofStrings($cuisines = Arr::get($json, 'recipeCuisine'))) {
            return $cuisines;
        }

        if (is_string($cuisines)) {
            return [$cuisines];
        }

        return null;
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string|null
     */
    protected function extractDescription(Crawler $crawler, array $json)
    {
        if (is_string($description = Arr::get($json, 'description'))) {
            return $description;
        }

        return null;
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string|null
     */
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

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string[]|null
     */
    protected function extractIngredients(Crawler $crawler, array $json)
    {
        if (Arr::ofStrings($ingredients = Arr::get($json, 'recipeIngredient'))) {
            return $ingredients;
        }

        if (is_string($ingredients)) {
            return [$ingredients];
        }

        if (Arr::ofStrings($ingredients = Arr::get($json, 'ingredients'))) {
            return $ingredients;
        }

        if (is_string($ingredients)) {
            return $ingredients;
        }

        return null;
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string[]|null
     */
    protected function extractInstructions(Crawler $crawler, array $json)
    {
        if (Arr::ofStrings($instructions = Arr::get($json, 'recipeInstructions'))) {
            return $instructions;
        }

        if (is_string($instructions)) {
            return [$instructions];
        }

        return null;
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string|null
     */
    protected function extractName(Crawler $crawler, array $json)
    {
        if (is_string($name = Arr::get($json, 'name'))) {
            return $name;
        }

        return null;
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string[]|null
     */
    protected function extractNotes(Crawler $crawler, array $json)
    {
        // No standard exists that I am aware of...
        return null;
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string|null
     */
    protected function extractPrepTime(Crawler $crawler, array $json)
    {
        if (is_string($prepTime = Arr::get($json, 'prepTime'))) {
            return $prepTime;
        }

        return null;
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string|null
     */
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

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string|null
     */
    protected function extractTotalTime(Crawler $crawler, array $json)
    {
        if (is_string($totalTime = Arr::get($json, 'totalTime'))) {
            return $totalTime;
        }

        return null;
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string|null
     */
    protected function extractUrl(Crawler $crawler, array $json)
    {
        if (is_string($url = Arr::get($json, 'url'))) {
            return $url;
        }

        return null;
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string|null
     */
    protected function extractYield(Crawler $crawler, array $json)
    {
        if (is_string($yield = Arr::get($json, 'recipeYield'))) {
            return $yield;
        }

        return null;
    }

    /**
     * @param  Crawler $crawler
     * @return array
     */
    protected function getJson(Crawler $crawler)
    {
        $scripts = $crawler->filter('script[type="application/ld+json"]');

        if (! $scripts->count()) {
            return [];
        }

        // Decode and normalize values to arrays of arrays (to match the case where we are given
        // multiple types per script element) and bring everything up a level with array_merge().
        $jsons = call_user_func_array('array_merge', $scripts->each(
            /**
             * @param Crawler $script
             * @return array
             */
            function (Crawler $script) {
                $json = json_decode($script->text(), true);

                if (null === $json || JSON_ERROR_NONE !== json_last_error()) {
                    return [];
                }

                // Normalize to array of arrays to match the case of multiple types per script.
                return Arr::ofArrays($json) ? $json : [$json];
            }
        ));

        // Remove any non-recipe elements.
        $recipes = array_filter(
            $jsons,
            /**
             * @param array $json
             * @return boolean
             */
            function (array $json) : bool {
                return is_array($json)
                    && $this->hasSchemaOrgContext($json)
                    && $this->hasRecipeType($json);
            }
        );

        if (! count($recipes)) {
            return [];
        }

        // And finally only return the first found recipe element.
        return array_shift($recipes);
    }

    /**
     * @param  array   $json
     * @return boolean
     */
    protected function hasRecipeType(array $json) : bool
    {
        return 'Recipe' === Arr::get($json, '@type');
    }

    /**
     * @param  array   $json
     * @return boolean
     */
    protected function hasSchemaOrgContext(array $json) : bool
    {
        // Should always be an exact match 'http://schema.org' but that doesn't seem
        // to be the case in the wild so we'll do a more lenient pattern match.
        return (bool) preg_match(
            '/https?:\/\/(?:w{3}\.)?schema\.org/',
            Arr::get($json, '@context')
        );
    }

    /**
     * @param  string|null $value
     * @return string|null
     */
    protected function normalizeInterval($value)
    {
        if (! is_string($value)) {
            return $value;
        }

        return Interval::normalize($value) ?: null;
    }

    /**
     * @param  mixed $value
     * @param  mixed $property
     * @return mixed
     *
     * @todo
     */
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

    /**
     * @param  string|null $value
     * @return string|null
     */
    protected function postNormalizeCookTime($value, $crawler)
    {
        return $this->normalizeInterval($value);
    }

    /**
     * @param  mixed $value
     * @return mixed
     *
     * @todo
     */
    protected function preNormalizeImage($value, $crawler)
    {
        return $this->normalizeObject($value, 'url');
    }

    /**
     * @param  string|null $value
     * @return string|null
     */
    protected function postNormalizePrepTime($value, $crawler)
    {
        return $this->normalizeInterval($value);
    }

    /**
     * @param  string|null $value
     * @return string|null
     */
    protected function postNormalizeTotalTime($value, $crawler)
    {
        return $this->normalizeInterval($value);
    }

    /**
     * @param  mixed $value
     * @return mixed
     *
     * @todo
     */
    protected function preNormalizeAuthor($value, $crawler)
    {
        return $this->normalizeObject($value, 'name');
    }

    /**
     * @param  mixed $value
     * @return mixed
     *
     * @todo
     */
    protected function preNormalizePublisher($value, $crawler)
    {
        return $this->normalizeObject($value, 'name');
    }
}
