<?php

namespace RecipeScraper\Scrapers;

use RecipeScraper\Extractors\Plural;
use RecipeScraper\Extractors\Singular;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Timestamps don't seem to match the displayed counterparts but displayed test isn't
 * always in a format that DateInterval::createFromDateString() understands.
 *
 * Sometimes includes links to other recipes in ingredients section.
 */
class EmerilsCom extends SchemaOrgMarkup
{
    public function supports(Crawler $crawler) : bool
    {
        return 'emerils.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
    }

    protected function extractCategories(Crawler $crawler)
    {
        return $this->extractor->make(Plural::class)
            ->extract($crawler, '.recipe-tags a');
    }

    protected function extractCuisines(Crawler $crawler)
    {
        return $this->extractor->make(Plural::class)
            ->extract($crawler, '.detail-cuisine a');
    }

    protected function extractDescription(Crawler $crawler)
    {
        // Has itemprop="description" but something weird in the markup...
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '[name="description"]', ['content']);
    }

    protected function extractImage(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '[itemprop="image"] img', ['data-original']);
    }

    protected function extractInstructions(Crawler $crawler)
    {
        if ($crawler->filter('.page-section-directions p')->count()) {
            return $this->extractor->make(Plural::class)
                ->extract($crawler, '.page-section-directions p');
        }

        return $this->extractor->make(Plural::class)
            ->extract($crawler, '.page-section-directions li');
    }

    protected function extractUrl(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '[rel="canonical"]', ['href']);
    }

    protected function extractYield(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '.meta-yield');
    }
}
