<?php

namespace RecipeScraper\Scrapers;

use RecipeScraper\Extractors\Plural;
use RecipeScraper\Extractors\Singular;
use Symfony\Component\DomCrawler\Crawler;

class WwwJustATasteCom extends SchemaOrgMarkup
{
    public function supports(Crawler $crawler) : bool
    {
        return 'www.justataste.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
    }

    protected function extractCategories(Crawler $crawler)
    {
        return $this->extractor->make(Plural::class)
            ->extract($crawler, '.category-link-single');
    }

    protected function extractDescription(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '[name="description"]', 'content');
    }

    protected function extractImage(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '[property="og:image"]', 'content');
    }

    protected function extractInstructions(Crawler $crawler)
    {
        return $this->extractor->make(Plural::class)
            ->extract($crawler, '[itemprop="recipeInstructions"] p');
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

    protected function preNormalizeCookTime($value)
    {
        return str_replace(' ', '', $value);
    }
}
