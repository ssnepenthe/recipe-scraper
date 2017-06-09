<?php

namespace RecipeScraper\Scrapers;

use RecipeScraper\Extractors\Plural;
use RecipeScraper\Extractors\Singular;
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

    protected function extractDescription(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '[name="description"]', ['content']);
    }

    protected function extractImage(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract(
                $crawler,
                '[itemtype="http://schema.org/Recipe"] [itemprop="image"]',
                ['content']
            );
    }

    protected function extractIngredients(Crawler $crawler)
    {
        return $this->extractor->make(Plural::class)
            ->extract(
                $crawler,
                '.ingredient-group strong, [itemprop="ingredients"]'
            );
    }

    protected function extractInstructions(Crawler $crawler)
    {
        return $this->extractor->make(Plural::class)
            ->extract($crawler, '.preparation-group strong, .preparation-step');
    }

    protected function extractUrl(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract(
                $crawler,
                '[itemtype="http://schema.org/Recipe"] [itemprop="url"]',
                ['content']
            );
    }
}
