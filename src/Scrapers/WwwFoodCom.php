<?php

namespace RecipeScraper\Scrapers;

use RecipeScraper\Extractors\Plural;
use RecipeScraper\Extractors\Singular;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Looks like there might be some encoding issues?
 *
 * We lose ingredient group titles by using LD+JSON. Drop down to displayed markup?
 */
class WwwFoodCom extends SchemaOrgJsonLd
{
    public function supports(Crawler $crawler) : bool
    {
        return parent::supports($crawler)
            && 'www.food.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
    }

    protected function extractInstructions(Crawler $crawler, array $json)
    {
        // Instructions in LD+JSON are smashed into one big text blob.
        return $this->extractor->make(Plural::class)
            ->extract($crawler, '.directions li');
    }

    protected function extractUrl(Crawler $crawler, array $json)
    {
        // URL is missing from LD+JSON.
        return $this->extractor->make(Singular::class)
            ->extract($crawler, '[rel="canonical"]', ['href']);
    }
}
