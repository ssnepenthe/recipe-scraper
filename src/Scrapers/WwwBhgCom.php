<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;

/**
 * FYI there is a JSON API if you send header 'Accept: application/json'.
 * They have nutrition info if we ever want it.
 */
class WwwBhgCom extends SchemaOrgMarkup
{
    public function supports(Crawler $crawler) : bool
    {
        return 'www.bhg.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
    }

    public function extractCookingMethod(Crawler $crawler)
    {
        // Cooking method itemprop is used on cooktimes...
        return null;
    }

    protected function extractCookTime(Crawler $crawler)
    {
        return $this->makeExtractor(self::SINGULAR_EXTRACTOR)
            ->extract($crawler, '[itemprop="cookTime"]', 'content');
    }

    protected function extractImage(Crawler $crawler)
    {
        return $this->makeExtractor(self::SINGULAR_EXTRACTOR)
            ->extract($crawler, '.recipe__image', 'content');
    }

    protected function extractIngredients(Crawler $crawler)
    {
        return $this->makeExtractor(self::PLURAL_CHILDREN_EXTRACTOR)
            ->extract($crawler, '[itemprop="recipeIngredient"]');
    }

    protected function extractInstructions(Crawler $crawler)
    {
        return $this->makeExtractor(self::PLURAL_EXTRACTOR)
            ->extract(
                $crawler,
                '.recipe__direction, .recipe__instructionGroupHeader'
            );
    }

    protected function extractName(Crawler $crawler)
    {
        return $this->makeExtractor(self::SINGULAR_EXTRACTOR)
            ->extract($crawler, 'h1[itemprop="name"]');
    }

    protected function extractPrepTime(Crawler $crawler)
    {
        return $this->makeExtractor(self::SINGULAR_EXTRACTOR)
            ->extract($crawler, '[itemprop="prepTime"]', 'content');
    }

    protected function extractYield(Crawler $crawler)
    {
        return $this->makeExtractor(self::SINGULAR_EXTRACTOR)
            ->extract($crawler, '[itemprop="recipeYield"]');
    }
}