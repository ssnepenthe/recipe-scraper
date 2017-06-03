<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;

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
        return $this->makeExtractor(self::PLURAL_EXTRACTOR)
            ->extract($crawler, 'a[href*="recipes/category/"]');
    }

    protected function extractCookTime(Crawler $crawler)
    {
        return $this->makeExtractor(self::SINGULAR_EXTRACTOR)
            ->extract($crawler, '[itemprop="cookTime"]', 'content');
    }

    protected function extractDescription(Crawler $crawler)
    {
        return $this->makeExtractor(self::SINGULAR_EXTRACTOR)
            ->extract($crawler, '[name="description"]', 'content');
    }

    protected function extractImage(Crawler $crawler)
    {
        return $this->makeExtractor(self::SINGULAR_EXTRACTOR)
            ->extract($crawler, '.main-image > img', 'data-lazy-src');
    }

    protected function extractIngredients(Crawler $crawler)
    {
        return $this->makeExtractor(self::PLURAL_CHILDREN_EXTRACTOR)
            ->extract($crawler, '[itemprop="ingredients"], .ingredients dt');
    }

    protected function extractInstructions(Crawler $crawler)
    {
        $selectors = [
            '[itemprop="recipeInstructions"] h4',
            '[itemprop="recipeInstructions"] li',
            '[itemprop="recipeInstructions"] strong',
        ];

        return $this->makeExtractor(self::PLURAL_CHILDREN_EXTRACTOR)
            ->extract($crawler, implode(', ', $selectors));
    }

    protected function extractPrepTime(Crawler $crawler)
    {
        return $this->makeExtractor(self::SINGULAR_EXTRACTOR)
            ->extract($crawler, '[itemprop="prepTime"]', 'content');
    }

    protected function extractUrl(Crawler $crawler)
    {
        return $this->makeExtractor(self::SINGULAR_EXTRACTOR)
            ->extract($crawler, '[rel="canonical"]', 'href');
    }

    protected function extractYield(Crawler $crawler)
    {
        return $this->makeExtractor(self::SINGULAR_EXTRACTOR)
            ->extract($crawler, '[itemprop="recipeYield"]');
    }
}
