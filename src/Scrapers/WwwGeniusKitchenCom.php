<?php

namespace RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Looks like there might be some encoding issues?
 *
 * We lose ingredient group titles by using LD+JSON. Drop down to displayed markup?
 *
 * Does not seem to have any notes.
 */
class WwwGeniusKitchenCom extends SchemaOrgJsonLd
{
    /**
     * @param  Crawler $crawler
     * @return boolean
     */
    public function supports(Crawler $crawler) : bool
    {
        return parent::supports($crawler)
            && 'www.geniuskitchen.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
    }

    /**
     * @param  Crawler $crawler
     * @param  array $json
     * @return string[]|null
     */
    protected function extractInstructions(Crawler $crawler, array $json)
    {
        // Instructions in LD+JSON are smashed into one big text blob.
        // Last child contains "submit a correction" link.
        return $this->extractArray($crawler, '.directions li:not(:last-child)');
    }

    /**
     * @param  Crawler $crawler
     * @param  array $json
     * @return string|null
     */
    protected function extractUrl(Crawler $crawler, array $json)
    {
        // URL is missing from LD+JSON.
        return $this->extractString($crawler, '[rel="canonical"]', ['href']);
    }
}
