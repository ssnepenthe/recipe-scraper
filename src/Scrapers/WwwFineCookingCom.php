<?php

namespace RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;
use RecipeScraper\ExtractsDataFromCrawler;

/**
 * Also has "tags" which could potentially be merged into recipe categories.
 *
 * We are missing out on ingredient group titles by using LD+JSON.
 *
 * Images are HTTP but all appear to redirect to HTTPS...
 */
class WwwFineCookingCom extends SchemaOrgJsonLd
{
    use ExtractsDataFromCrawler;

    /**
     * @param  Crawler $crawler
     * @return boolean
     */
    public function supports(Crawler $crawler) : bool
    {
        return parent::supports($crawler)
            && 'www.finecooking.com' === parse_url($crawler->getUri(), PHP_URL_HOST);
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string|null
     */
    protected function extractDescription(Crawler $crawler, array $json)
    {
        // LD+JSON description is truncated.
        return $this->extractString($crawler, '.recipe__blurb');
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string[]|null
     */
    protected function extractNotes(Crawler $crawler, array $json)
    {
        return $this->extractArray($crawler, '.module--tip p');
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string|null
     */
    protected function extractUrl(Crawler $crawler, array $json)
    {
        return $this->extractString($crawler, '[rel="canonical"]', ['href']);
    }

    /**
     * @param  Crawler $crawler
     * @param  array   $json
     * @return string|null
     */
    protected function extractYield(Crawler $crawler, array $json)
    {
        // See http://www.finecooking.com/recipe/ancho-marinated-pork-and-mango-skewers.
        // It looks like LD+JSON inaccurately strips non-numeric characters from yield which leaves
        // us with 42 instead of 4. So instead, get from markup and strip out the heading.
        if (! $yield = $this->extractString($crawler, '.recipe__yield')) {
            return null;
        }

        if (! $heading = $this->extractString($crawler, '.recipe__yield__heading')) {
            return $yield;
        }

        return str_replace($heading, '', $yield);
    }
}
