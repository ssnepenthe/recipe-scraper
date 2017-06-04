<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Some recipes have notes if we want them.
 * Also has nutrition info if we want it.
 */
class WwwEpicuriousCom extends SchemaOrgMarkup
{
    public function supports(Crawler $crawler) : bool
    {
        return 'www.epicurious.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
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
            ->extract(
                $crawler,
                '[itemtype="http://schema.org/Recipe"] [itemprop="image"]',
                'content'
            );
    }

    protected function extractIngredients(Crawler $crawler)
    {
        return $this->makeExtractor(self::PLURAL_EXTRACTOR)
            ->extract(
            	$crawler,
            	'.ingredient-group strong, [itemprop="ingredients"]'
            );
    }

    protected function extractInstructions(Crawler $crawler)
    {
        return $this->makeExtractor(self::PLURAL_EXTRACTOR)
            ->extract($crawler, '.preparation-group strong, .preparation-step');
    }

    protected function extractPrepTime(Crawler $crawler)
    {
        return $this->makeExtractor(self::SINGULAR_EXTRACTOR)
            ->extract($crawler, '[itemprop="prepTime"]', 'content');
    }

    protected function extractUrl(Crawler $crawler)
    {
        return $this->makeExtractor(self::SINGULAR_EXTRACTOR)
            ->extract(
                $crawler,
                '[itemtype="http://schema.org/Recipe"] [itemprop="url"]',
                'content'
            );
    }

    protected function extractYield(Crawler $crawler)
    {
        return $this->makeExtractor(self::SINGULAR_EXTRACTOR)
            ->extract($crawler, '[itemprop="recipeYield"]');
    }
}
