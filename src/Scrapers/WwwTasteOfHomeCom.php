<?php

namespace RecipeScraper\Scrapers;

use RecipeScraper\Extractors\Plural;
use RecipeScraper\Extractors\Singular;
use Symfony\Component\DomCrawler\Crawler;

class WwwTasteOfHomeCom extends SchemaOrgMarkup
{
    public function supports(Crawler $crawler) : bool
    {
        return 'www.tasteofhome.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
    }

    protected function extractAuthor(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '[itemprop="author"] [itemprop="name"]', 'content');
    }

    protected function extractDescription(Crawler $crawler)
    {
        // Incorrectly uses schema.org/recipe (with lowercase "r").
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '[itemprop="description"]');
    }

    protected function extractImage(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '[itemprop="image"]', 'content');
    }

    protected function extractInstructions(Crawler $crawler)
    {
        return $this->extractor->make(Plural::class)
            ->extract($crawler, '[itemprop="recipeInstructions"] .rd_name');
    }

    protected function extractName(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '[itemprop="name"]', 'content');
    }

    protected function extractUrl(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '[rel="canonical"]', 'href');
    }

    protected function extractYield(Crawler $crawler)
    {
        return $this->extractor->make(Singular::class)
            // Lowercase "y".
            ->extract($crawler, '[itemprop="recipeyield"]');
    }
}
