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
        'notes',
        'prepTime',
        'publisher',
        'totalTime',
        'url',
        'yield',
        'nutrition'
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

        $recipe = [];

        foreach ($this->properties as $key) {
            $methodKey = ucfirst($key);
            $extractor = "extract{$methodKey}";
            $preNormalizer = "preNormalize{$methodKey}";
            $postNormalizer = "postNormalize{$methodKey}";

            $value = $this->{$extractor}($crawler);

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
        return (bool) $crawler->filter('[itemtype*="schema.org/Recipe"]')->count();
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractAuthor(Crawler $crawler)
    {
        return $this->extractString(
            $crawler,
            '[itemtype*="schema.org/Recipe"] [itemprop="author"]'
        );
    }

    /**
     * TODO implement nutrition support
     * @param  Crawler $crawler
     * @return array|null
     */
    protected function extractNutrition(Crawler $crawler)
    {
        $nutritionFields = [
            'calories' => 'invalid-DOM',
            'fat' => 'invalid-DOM',
            'fiber' => 'invalid-DOM',
            'protein' => 'invalid-DOM',
            'sugar' => 'invalid-DOM'
        ];

        $nutrition = [];

        foreach ($nutritionFields as $nutritionField => $domElement) {
            $nutrition[$nutritionField] = $this->extractString(
                $crawler,
                '[itemtype*="schema.org/Recipe"] [itemprop="' . $domElement .'"]'
            );
        }

        return $nutrition;
    }
    /**
     * @param  Crawler $crawler
     * @return string[]|null
     */
    protected function extractCategories(Crawler $crawler)
    {
        return $this->extractArray($crawler, '[itemprop="recipeCategory"]');
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractCookingMethod(Crawler $crawler)
    {
        return $this->extractString(
            $crawler,
            '[itemtype*="schema.org/Recipe"] [itemprop="cookingMethod"]'
        );
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractCookTime(Crawler $crawler)
    {
        return $this->extractString(
            $crawler,
            '[itemprop="cookTime"]',
            ['datetime', 'content', '_text']
        );
    }

    /**
     * @param  Crawler $crawler
     * @return string[]|null
     */
    protected function extractCuisines(Crawler $crawler)
    {
        return $this->extractArray($crawler, '[itemprop="recipeCuisine"]');
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractDescription(Crawler $crawler)
    {
        return $this->extractString(
            $crawler,
            '[itemtype*="schema.org/Recipe"] [itemprop="description"]'
        );
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractImage(Crawler $crawler)
    {
        return $this->extractString(
            $crawler,
            '[itemtype*="schema.org/Recipe"] [itemprop="image"]',
            ['content', 'src']
        );
    }

    /**
     * @param  Crawler $crawler
     * @return string[]|null
     */
    protected function extractIngredients(Crawler $crawler)
    {
        return $this->extractArray(
            $crawler,
            '[itemprop="recipeIngredient"], [itemprop="ingredients"]'
        );
    }

    /**
     * @param  Crawler $crawler
     * @return string[]|null
     */
    protected function extractInstructions(Crawler $crawler)
    {
        return $this->extractArray($crawler, '[itemprop="recipeInstructions"]');
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractName(Crawler $crawler)
    {
        return $this->extractString(
            $crawler,
            '[itemtype*="schema.org/Recipe"] [itemprop="name"]'
        );
    }

    /**
     * @param  Crawler $crawler
     * @return string[]|null
     */
    protected function extractNotes(Crawler $crawler)
    {
        // No standard exists that I am aware of...
        return null;
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractPrepTime(Crawler $crawler)
    {
        return $this->extractString(
            $crawler,
            '[itemprop="prepTime"]',
            ['datetime', 'content', '_text']
        );
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractPublisher(Crawler $crawler)
    {
        return $this->extractString(
            $crawler,
            '[itemtype*="schema.org/Recipe"] [itemprop="publisher"]'
        );
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractTotalTime(Crawler $crawler)
    {
        return $this->extractString(
            $crawler,
            '[itemprop="totalTime"]',
            ['datetime', 'content', '_text']
        );
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractUrl(Crawler $crawler)
    {
        return $this->extractString(
            $crawler,
            '[itemtype*="schema.org/Recipe"] [itemprop="url"]',
            ['content', 'href']
        );
    }

    /**
     * @param  Crawler $crawler
     * @return string|null
     */
    protected function extractYield(Crawler $crawler)
    {
        return $this->extractString($crawler, '[itemprop="recipeYield"]', ['content', '_text']);
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
     * @param  string|null $value
     * @param  Crawler     $crawler
     * @return string|null
     */
    protected function postNormalizeCookTime($value, Crawler $crawler)
    {
        return $this->normalizeInterval($value);
    }

    /**
     * @param  string|null $value
     * @param  Crawler     $crawler
     * @return string|null
     */
    protected function postNormalizePrepTime($value, Crawler $crawler)
    {
        return $this->normalizeInterval($value);
    }

    /**
     * @param  string|null $value
     * @param  Crawler     $crawler
     * @return string|null
     */
    protected function postNormalizeTotalTime($value, Crawler $crawler)
    {
        return $this->normalizeInterval($value);
    }
}
