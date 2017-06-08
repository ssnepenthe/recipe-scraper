<?php

namespace RecipeScraper\Scrapers;

use RecipeScraper\Extractors\Plural;
use RecipeScraper\Extractors\Singular;
use Symfony\Component\DomCrawler\Crawler;
use RecipeScraper\Extractors\PluralFromChildren;

/**
 * This site is powered by WordPress but at the time of this writing the recipe post
 * type is hidden from the REST API.
 */
class SpryLivingCom extends SchemaOrgMarkup
{
    public function supports(Crawler $crawler) : bool
    {
        return 'spryliving.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
    }

    protected function extractCategories(Crawler $crawler)
    {
        return $this->extractor->make(Plural::class)
            ->extract($crawler, 'a[href*="recipes/category/"]');
    }

    protected function extractCookTime(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '[itemprop="cookTime"]', 'content');
    }

    protected function extractDescription(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '[name="description"]', 'content');
    }

    protected function extractImage(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '.main-image > img', 'data-lazy-src');
    }

    protected function extractIngredients(Crawler $crawler)
    {
        return $this->extractor->make(PluralFromChildren::class)
            ->extract($crawler, '[itemprop="ingredients"], .ingredients dt');
    }

    protected function extractInstructions(Crawler $crawler)
    {
        $selectors = [
            '[itemprop="recipeInstructions"] h4',
            '[itemprop="recipeInstructions"] li',
            '[itemprop="recipeInstructions"] strong',
        ];

        return $this->extractor->make(PluralFromChildren::class)
            ->extract($crawler, implode(', ', $selectors));
    }

    protected function extractPrepTime(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '[itemprop="prepTime"]', 'content');
    }

    protected function extractUrl(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '[rel="canonical"]', 'href');
    }

    protected function extractYield(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '[itemprop="recipeYield"]');
    }
}
